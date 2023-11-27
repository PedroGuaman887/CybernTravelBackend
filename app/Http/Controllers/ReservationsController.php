<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Models\Requests;
use App\Models\Properties;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReservationsController extends Controller
{
    public function createdReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'startDate' => 'date_format:Y-m-d',
            //'endDate' => 'date_format:Y-m-d',
            //'datePayment' => 'date_format:Y-m-d',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $newReservation = new Reservations([
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'datePayment' => $request->datePayment,
            'status' => $request->status,
            'idRequests' => $request->idRequests,
        ]);

        return response()->json([
            'message' => 'User successfully reservation',
            'reservation' => $newReservation,
        ], 201);
    }

    public function updateReservation(Request $request, $id)
    {
        $reservations = Reservations::find($id);

        $reservations->startDate = $request->startDate;
        $reservations->endDate = $request->endDate;
        $reservations->datePayment = $request->dateRequest;
        $reservations->status = $request->status;
        $reservations->idRequests = $request->idRequests;
        
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
                'reservations.datePayment', 
                'reservations.status', 

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
                'properties.propertySecurity')
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
}
