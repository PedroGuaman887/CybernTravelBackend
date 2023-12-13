<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Models\StatusProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class StatusPropertyController extends Controller
{
    public function createStatusPause(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startDate' => 'required',
            'endDate' => 'required',
            'idProperty' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $statusProperty = new StatusProperty([

            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'status' => 'Pausado',
        ]);
        $statusProperty->idProperty = $request->idProperty;

        $statusProperty->save();


        return response()->json([
            'message' => 'Status created successfully',
            'statusProperty' => $statusProperty,
            //'properties' => $property,
        ], 201);
    }
    public function DeleteStatusProperty($idProperties)
    {
        $deleted = StatusProperty::where('idProperty', $idProperties)->delete();

        if ($deleted) {
            return response()->json(['message' => 'removed']);
        } else {
            return response()->json(['message' => 'no removed'], 404);
        }
    }

    public function statusPauseByIdProperties($idProperty)
    {
        $currentDate = now()->toDateString();

         $status = DB::table('status_properties')
            ->leftJoin('properties', 'properties.idProperty', '=', 'status_properties.idProperty')
            ->where('properties.idProperty', '=', $idProperty)
            ->where(function ($query) use ($currentDate) {
              $query->whereNull('status_properties.idProperty')
                  ->orWhereNotNull('status_properties.idProperty')
                 ->where('status_properties.startDate', '>=', $currentDate);
                 })
                ->select(
                'status_properties.idStatus',
                'status_properties.startDate',
                'status_properties.endDate',
                'status_properties.idProperty',
            )
            ->get();

         return $status;
    }
}
