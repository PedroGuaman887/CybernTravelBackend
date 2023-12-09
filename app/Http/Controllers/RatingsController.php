<?php

namespace App\Http\Controllers;

use App\Models\Qualification;
use App\Models\Ratings;
use App\Models\Reservations;
use App\Models\User;
use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RatingsController extends Controller
{

    public function createdRatings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ratingCleaning' => 'required|integer',
            'ratingPunctuality' => 'required|integer',
            'ratingFriendliness' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $reservation = Reservations::find($request->idReservations);

        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }
        /*         $existingRating = Ratings::where('idUser', $request->idUser)->count();

        if ($existingRating > 0) {
            return response()->json(['error' => 'You have already rated this reservation'], 400);
        } */
        $calificationDeadline = Carbon::parse($reservation->endDate)->addDays(7);

        if (now()->lessThanOrEqualTo($calificationDeadline)) {
            $rating = new ratings([
                'ratingCleaning' => $request->ratingCleaning,
                'ratingPunctuality' => $request->ratingPunctuality,
                'ratingFriendliness' => $request->ratingFriendliness,
                'ratingComment' => $request->ratingComment,
            ]);

            $rating->idReservations = $reservation->idReservations;
            $rating->idProperty = $reservation->idProperty;
            $rating->idUser = $request->idUser;

            $rating->save();

            $property = Properties::find($rating->idProperty);

            $host = User::find($property->host_id);

            $existingQualification = Qualification::where('idUser', $host->idUser)->first();

            if ($existingQualification) {
                $existingQualification->ratingCleaning += $request->ratingCleaning;
                $existingQualification->ratingPunctuality += $request->ratingPunctuality;
                $existingQualification->ratingComunication += $request->ratingFriendliness;
                $existingQualification->qualificationAmount += 1;
                $existingQualification->save();
                $qualification = $existingQualification;
            } else {
                $qualification = new Qualification([
                    'ratingCleaning' => $request->ratingCleaning,
                    'ratingPunctuality' => $request->ratingPunctuality,
                    'ratingComunication' => $request->ratingFriendliness,
                    'qualificationAmount' => 1,
                ]);

                $qualification->idUser = $host->idUser;
                $qualification->save();
            }


            return response()->json([
                'message' => 'User successfully rating',
                'rating' => $rating,
                'idreservation' => $reservation->idReservations,
                'idProperty' => $reservation->idProperty,
                'host_id' => $host->idUser,
                'qualification host' => $qualification
            ], 201);
        } else {
            return response()->json(['error' => 'Rating period has expired'], 400);
        }
    }

    public function ratingsByIdProperty(Request $request)
    {
        $propertyId = $request->idProperty;

        $ratings = DB::table('ratings')
            ->leftJoin('properties', 'properties.idProperty', '=', 'ratings.idProperty')
            ->where('properties.idProperty', '=', $propertyId)
            ->select(
                'ratings.idRatings',
                'ratings.ratingComment',
                'ratings.ratingPunctuality',
                'ratings.ratingCleaning',
                'ratings.ratingFriendliness',
                'properties.idProperty',
                'properties.propertyName',
                'properties.propertyOperation',
                'properties.propertyType',
                'properties.propertyAddress',
                'properties.propertyDescription',
                'properties.propertyServices',
                'properties.propertyStatus',
                'properties.propertyAmount',
                'properties.propertyAbility',
                'properties.propertyCity',
                'properties.host_id',
            )
            ->get();

        $totalPunctuality = 0;
        $totalCleaning = 0;
        $totalFriendliness = 0;
        $totalRatings = count($ratings);

        foreach ($ratings as $rating) {
            $totalPunctuality += $rating->ratingPunctuality;
            $totalCleaning += $rating->ratingCleaning;
            $totalFriendliness += $rating->ratingFriendliness;
        }

        $averagePunctuality = $totalPunctuality / $totalRatings;
        $averageCleaning = $totalCleaning / $totalRatings;
        $averageFriendliness = $totalFriendliness / $totalRatings;

        $response = [
            'ratings' => $ratings,
            'averageRatings' => [
                'averagePunctuality' => $averagePunctuality,
                'averageCleaning' => $averageCleaning,
                'averageFriendliness' => $averageFriendliness,
            ],
        ];

        return response()->json($response);
    }

    public function deleteRatings(Request $request)
    {
        $deleted = Ratings::destroy($request->idRatings);

        if ($deleted) {
            return response()->json(['message' => 'rating removed']);
        } else {
            return response()->json(['message' => 'there is no rating'], 404);
        }
    }
}
