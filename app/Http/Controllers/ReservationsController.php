<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Models\Properties;
use App\Models\NotificationsHosts;
use App\Models\NotificationsUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReservationsController extends Controller
{
    public function createdReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startDate' => 'date_format:Y-m-d',
            'endDate' => 'date_format:Y-m-d',
            'totalAmount' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $existingReservation = Reservations::where('idProperty', $request->idProperty)
            ->where(function ($query) use ($request) {
                $query->whereBetween('startDate', [$request->startDate, $request->endDate])
                    ->orWhereBetween('endDate', [$request->startDate, $request->endDate])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('startDate', '<=', $request->startDate)
                            ->where('endDate', '>=', $request->endDate);
                    });
            })
            ->first();

        if ($existingReservation) {
            return response()->json(['error' => 'There is already a reservation in the specified date range.'], 400);
        }

        $newReservation = new Reservations([
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'totalAmount' => $request->totalAmount,
        ]);

        $newReservation->idProperty = $request->idProperty;
        $newReservation->idUser = $request->idUser;

        $newReservation->save();

        $property = Properties::find($request->idProperty);

        $host = User::find($property->host_id);

        $notificationUser = new NotificationsUsers([
            'nameProperty' => $property->propertyName,
            'nameHost' => $host->fullName,
            'phoneHost' => $host->phoneNumber,
        ]);

        $notificationUser->idProperty = $request->idProperty;
        $notificationUser->idUser = $request->idUser;

        $notificationUser->save();

        $user = User::find($request->idUser);

        $notificationHost = new NotificationsHosts([
            'startDate' => $newReservation->startDate,
            'endDate' => $newReservation->endDate,
            'nameProperty' => $property->propertyName,
            'nameUser' => $user->fullName,
        ]);

        $notificationHost->idProperty = $request->idProperty;
        $notificationHost->host_id = $property->host_id;

        $notificationHost->save();

        return response()->json([
            'message' => 'User successfully reservation',
            'reservation' => $newReservation,
            'notificationUser' => $notificationUser,
            'notificationHost' => $notificationHost,
        ], 201);
    }

    public function updateReservation(Request $request, $id)
    {
        $reservations = Reservations::find($id);

        $reservations->startDate = $request->startDate;
        $reservations->endDate = $request->endDate;
        $reservations->totalAmount = $request->totalAmount;

        $reservations->save();
        return $reservations;
    }

    public function reservationById(Request $request)
    {
        $reservation = DB::table('reservations')
            ->leftJoin('users', 'users.idUser', '=', 'reservations.idUser')
            ->leftJoin('properties', 'properties.idProperty', '=', 'reservations.idProperty')
            ->where('reservations.idReservations', '=', $request->idReservations)
            ->where(function ($query) {
                $query->whereNull('reservations.idReservations')
                    ->orWhereNotNull('reservations.idReservations');
            })
            ->select(
                'reservations.idReservations',
                'reservations.startDate',
                'reservations.endDate',
                'reservations.totalAmount',

                'users.idUser',
                'users.fullName',
                'users.email',
                'users.phoneNumber',
                'users.birthDate',

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
                'properties.propertyCroquis',
                'properties.propertyRooms',
                'properties.propertyBathrooms',
                'properties.propertyBeds',
                'properties.propertyRules',
                'properties.propertySecurity'
            )
            ->get();

        return $reservation;
    }

    public function getAllReservations()
    {
        $requests = Reservations::all();

        foreach ($requests as $request) {

            if ($request->idUser !== null) {
                $user = User::find($request->idUser);
                $request->user = [
                    'idUser' => $user->idUser,
                    'fullName' => $user->fullName,
                    'email' => $user->email,
                    'phoneNumber' => $user->phoneNumber,
                    'birthDate' => $user->birthDate
                ];
            }

            if ($request->idProperty !== null) {
                $properties = Properties::find($request->idProperty);
                $request->properties = [
                    'idProperty' => $properties->idProperty,
                    'propertyName' => $properties->propertyName,
                    'propertyOperation' => $properties->propertyOperation,
                    'propertyType' => $properties->propertyType,
                    'propertyAddress' => $properties->propertyAddress,
                    'propertyDescription' => $properties->propertyDescription,
                    'propertyServices' => $properties->propertyServices,
                    'propertyStatus' => $properties->propertyStatus,
                    'propertyAmount' => $properties->propertyAmount,
                    'propertyAbility' => $properties->propertyAbility,
                    'propertyCity' => $properties->propertyCity,
                    'propertyCroquis' => $properties->propertyCroquis,
                    'propertyRooms' => $properties->propertyRooms,
                    'propertyBathrooms' => $properties->propertyBathrooms,
                    'propertyBeds' => $properties->propertyBeds,
                    'propertyRules' => $properties->propertyRules,
                    'propertySecurity' => $properties->propertySecurity
                ];
            }
        }

        return $requests;
    }
    public function getAllReservationsOfaProperty($id)
    {
        try {
            $reservations = Reservations::select('startDate', 'endDate', 'idProperty')->where('idProperty', $id)->get();
            return response()->json($reservations);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reservationByIdUser($idUser)
    {
        DB::statement("SET SQL_MODE=''");

        $reservations = DB::table('reservations')
            ->leftJoin('users', 'users.idUser', '=', 'reservations.idUser')
            ->leftJoin('properties', 'properties.idProperty', '=', 'reservations.idProperty')
            ->leftJoin(DB::raw('(SELECT property_id, MIN(idImages) as minImage FROM images GROUP BY property_id) as first_images'), function ($join) {
                $join->on('properties.idProperty', '=', 'first_images.property_id');
            })
            ->leftJoin('images', function ($join) {
                $join->on('images.idImages', '=', 'first_images.minImage');
            })
            ->where('users.idUser', '=', $idUser)
            ->where(function ($query) {
                $query->whereNull('reservations.idUser')
                    ->orWhereNotNull('reservations.idUser');
            })
            ->select(
                'reservations.startDate',
                'reservations.totalAmount',
                'reservations.endDate',
                'reservations.idProperty',
                'reservations.idUser',
                'properties.propertyName',
                'properties.propertyDescription',
                'properties.propertyAmount',
                'properties.propertyAbility',
                'properties.propertyCity',
                'images.imageLink'
            )
            ->get();

        return response()->json($reservations);
    }

    public function reservationByIdProperties($idProperty)
    {
        $currentDate = now()->toDateString(); // Obtener la fecha actual

        $reservation = DB::table('reservations')
            ->leftJoin('properties', 'properties.idProperty', '=', 'reservations.idProperty')
            ->where('properties.idProperty', '=', $idProperty)
            ->where(function ($query) use ($currentDate) {
                $query->whereNull('reservations.idProperty')
                    ->orWhereNotNull('reservations.idProperty')
                    ->where('reservations.startDate', '>=', $currentDate);
            })
            ->select(
                'reservations.idReservations',
                'reservations.startDate',
                'reservations.totalAmount',
                'reservations.endDate',
                'reservations.idProperty',
                'reservations.idUser',

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
                'properties.propertyCroquis',
                'properties.propertyRooms',
                'properties.propertyBathrooms',
                'properties.propertyBeds',
                'properties.propertyRules',
                'properties.propertySecurity'
            )
            ->get();

        return $reservation;
    }
}
