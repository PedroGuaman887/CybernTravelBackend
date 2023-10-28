<?php

namespace App\Http\Controllers;

use App\Models\Holidays;
use App\Models\Properties;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PropertiesController extends Controller
{
    public function createdProperties(Request $request)
    {
        $validator = Validator::make($request->all(), [  //valida los maximos y
            'propertyName' => 'required|string|min:1|max:100',
            'propertyPicture' => 'required|string|min:1|max:100',
            'propertyOperation' => 'required|string|min:1|max:100',
            'propertyType' => 'required|string|min:1|max:100',
            'propertyAddress' => 'required|string|min:1|max:100',
            'propertyDescription' => 'required|string|min:1|max:500',
            'propertyServices' => 'required|string|min:1|max:100',
            'propertyStatus' => 'required|string|min:1|max:100',
            'propertyAmount' => 'required|integer|min:0',
            'propertyAbility' => 'required|integer|min:0', 
            'host_id' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $property = new properties([
            'propertyName' => $request->propertyName,
            'propertyPicture' => $request->propertyPicture,
            'propertyOperation' => $request->propertyOperation,
            'propertyType' => $request->propertyType,
            'propertyAddress' => $request->propertyAddress,
            'propertyDescription' => $request->propertyDescription,
            'propertyServices' => $request->propertyServices,
            'propertyStatus' => $request->propertyStatus,
            'propertyAmount' => $request->propertyAmount, 
            'propertyAbility' => $request->propertyAbility,

        ]);
        $property->host_id = $request->host_id;
        //$property = Properties::create($request->all());
        $property->save();


        $propertyId = $property->idProperty; 

        $holidays = $request->input('holidays');

        if (!is_array($holidays)) {
            return response()->json([
                'message' => 'El campo holidays debe ser un array válido.',
            ], 400);
        }

        foreach ($holidays as $holidayData) {
            $holiday = new Holidays([
                'startDate' => $holidayData['startDate'],
                'endDate' => $holidayData['endDate'],
                'amount' => $holidayData['amount'],
            ]);
            if (!empty($propertyId)) {
                $holiday->property_id = $propertyId;
            } else {
                return response()->json([
                    'message' => 'el id de la propieda no existe',
                    'propertyId' => $propertyId,
                ], 201);
            }
            $holiday->save();
        }

        return response()->json([
            'message' => 'successful property registration.',
            'properties' => $property,
            'holidays' => $holidays,
        ], 201);
    }

    public function propertiesById(Request $request)
    {
        $properties = DB::table('properties')
        ->leftJoin('users', 'users.idUser', '=', 'properties.host_id')
        ->where('idProperty', '=', $request->idProperty)
        ->where(function ($query) {
            $query->whereNull('properties.host_id')
                ->orWhereNotNull('properties.host_id');
        })
            ->select(

                'users.idUser',
                'users.fullName',
                'users.email',
                'users.phoneNumber',
                'users.birthDate',

                'properties.idProperty',
                'properties.propertyName',
                'properties.propertyPicture',
                'properties.propertyOperation',
                'properties.propertyType',
                'properties.propertyAddress',
                'properties.propertyDescription',
                'properties.propertyServices',
                'properties.propertyStatus',
                'properties.propertyAmount',
                'properties.propertyAbility',
                'properties.host_id',
            )
            ->get();

        return $properties;
    }

    public function updateProperties(Request $request, $id)
    {
        $properties = properties::find($id);

        $properties->propertyName = $request->propertyName;
        $properties->propertyPicture = $request->propertyPicture;
        $properties->propertyOperation = $request->propertyOperation;
        $properties->propertyType = $request->propertyType;
        $properties->propertyAddress = $request->propertyAddress;
        $properties->propertyDescription = $request->propertyDescription;
        $properties->propertyServices = $request->propertyServices;
        $properties->propertyStatus = $request->propertyStatus;
        $properties->propertyAmount = $request->propertyAmount;
        $properties->propertyAbility = $request->propertyAbility;

        $properties->save();
        return $properties;
    }

    public function deleteProperties(Request $request)
    {
        $deleted = properties::destroy($request->idProperty);

        if ($deleted) {
            return response()->json(['message' => 'property removed']);
        } else {
            return response()->json(['message' => 'there is no property'], 404);
        }
    }
}
