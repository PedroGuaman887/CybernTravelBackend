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


        return response()->json([
            'message' => 'Status created successfully',
            'statusProperty' => $statusProperty,
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

    public function statusPropertiesByIdProperties($property_id)
    {

        $statusProperties = DB::table('status_properties')
            ->leftJoin('properties', 'properties.idProperty', '=', 'status_properties.property_id')
            ->where('properties.idProperty', '=', $property_id)
            ->where(function ($query){
                $query->whereNull('status_properties.property_id')
                    ->orWhereNotNull('status_properties.property_id');
            })
            ->select(
                'status_properties.idStatus',
                'status_properties.startDate',
                'status_properties.endDate',
                'status_properties.property_id',

            )
            ->get();

        return $statusProperties;
    }
}
