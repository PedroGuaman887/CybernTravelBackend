<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Models\StatusProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatusPropertyController extends Controller
{
    public function createStatusPause(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startDate' => 'required',
            'endDate' => 'required',
            'property_id' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $statusProperty = new StatusProperty([

            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'status' => 'Pausado',
        ]);
        $statusProperty->property_id = $request->property_id;

        $statusProperty->save();

        $newReservation = new Reservations([
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'totalAmount' => 0,
        ]);

        $newReservation->idProperty = $request->property_id;
        $newReservation->idUser = 1;

        $newReservation->save();

        return response()->json([
            'message' => 'Status created successfully',
            'statusProperty' => $statusProperty,
            'reservation' => $newReservation
            //'properties' => $property,
        ], 201);
    }
    public function DeleteStatusProperty($idProperties)
    {
        $deleted = StatusProperty::where('property_id', $idProperties)->delete();

        if ($deleted) {
            return response()->json(['message' => 'removed']);
        } else {
            return response()->json(['message' => 'no removed'], 404);
        }
    }
}
