<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
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
}
