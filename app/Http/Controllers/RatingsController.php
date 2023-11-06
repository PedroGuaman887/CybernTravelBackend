<?php

namespace App\Http\Controllers;

use App\Models\Ratings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RatingsController extends Controller
{

    public function createdRatings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ratingStar' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $rating = new ratings([

            'ratingStar' => $request->ratingStar,
            'ratingComment' => $request->ratingComment,

        ]);
        $rating->property_id = $request->property_id;

        $rating->save();


        $ratingId = $rating->idRatings;

        $property = $request->input('property');

        if (!is_array($property)) {
            return response()->json([
                'message' => 'El campo rating debe ser un array válido.',
            ], 400);
        }

        return response()->json([
            'message' => 'User successfully rating',
            'images' => $rating,
            'properties' => $property,
        ], 201);
    }

    public function ratingsById(Request $request)
    {
        $rating = DB::table('ratings')
            ->leftJoin('properties', 'properties.idProperty', '=', 'ratings.property_id')
            ->where('idRatings', '=', $request->idRatings)
            ->where(function ($query) {
                $query->whereNull('ratings.property_id')
                    ->orWhereNotNull('ratings.property_id');
            })
            ->select(
                'ratings.idRatings',
                'ratings.ratingStar',
                'ratings.ratingComment',

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

        return $rating;
    }

    public function updateRatings(Request $request, $id)
    {
        $ratings = Ratings::find($id);

        $ratings->ratingStar = $request->ratingStar;
        $ratings->ratingComment = $request->ratingComment;

        $ratings->save();
        return $ratings;
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
