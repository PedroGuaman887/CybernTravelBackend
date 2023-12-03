<?php

namespace App\Http\Controllers;

use App\Models\Holidays;
use App\Models\Images;
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
        try {
            $validator = Validator::make($request->all(), [  //valida los maximos y
                'propertyName' => 'required|string|min:1|max:50',
                'propertyOperation' => 'required|string|min:1|max:100',
                'propertyType' => 'required|string|min:1|max:100',
                'propertyAddress' => 'required|string|min:1|max:100',
                'propertyDescription' => 'required|string|min:1|max:200',
                'propertyServices' => 'required|string|min:1|max:100',
                'propertyStatus' => 'required|string|min:1|max:100',
                'propertyAmount' => 'required|integer|min:0',
                'propertyAbility' => 'required|integer|min:0',
                'propertyCity' => 'required',
                'propertyCroquis' => 'required|string',
                'propertyRooms' => 'required|integer|min:1',
                'propertyBathrooms' => 'required|integer|min:1',
                'propertyBeds' => 'required|integer|min:1',
                'propertyRules' => 'required|string',
                'propertySecurity' => 'required|string',
                'host_id' => 'required|integer|min:0',
                'holidays' => 'required',
                'images' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $property = new properties([
                'propertyName' => $request->propertyName,
                'propertyOperation' => $request->propertyOperation,
                'propertyType' => $request->propertyType,
                'propertyAddress' => $request->propertyAddress,
                'propertyDescription' => $request->propertyDescription,
                'propertyServices' => $request->propertyServices,
                'propertyStatus' => $request->propertyStatus,
                'propertyAmount' => $request->propertyAmount,
                'propertyCity' => $request->propertyCity,
                'propertyAbility' => $request->propertyAbility,
                'propertyCroquis' => $request->propertyCroquis,
                'propertyRooms' => $request->propertyRooms,
                'propertyBathrooms' => $request->propertyBathrooms,
                'propertyBeds' => $request->propertyBeds,
                'propertyRules' => $request->propertyRules,
                'propertySecurity' => $request->propertySecurity,

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
                    'status' => $holidayData['status'],
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
            $images =  $request->input('images');

            if (!is_array($images)) {
                return response()->json([
                    'message' => 'El campo images debe ser un array válido.',
                ], 400);
            }

            foreach ($images as $image) {
                $image_property = new Images([
                    'imageLink' => $image['imageLink'],
                    'imageDescription' => $image['imageDescription'],
                ]);
                if (!empty($propertyId)) {
                    $image_property->property_id = $propertyId;
                    $image_property->save();
                } else {
                    return response()->json([
                        'message' => 'El ID de la propiedad no existe',
                        'propertyId' => $propertyId,
                    ], 400); // Usar un código de respuesta 400 para errores
                }
                $image_property->save();
            }


            return response()->json([
                'message' => 'successful property registration.',
                'properties' => $property,
                'holidays' => $holidays,
                'Images_Property' => $images,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar la propiedad.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAllProperties(Request $request)
    {
        /* 
        obtener datos del alojamiento y la primera imagen registrada del alojamiento
        SELECT idProperty, propertyName, propertyAmount,propertyAbility, images.imageLink, images.property_id
        FROM properties
        JOIN (SELECT * FROM images GROUP BY property_id) as images ON properties.idProperty = images.property_id 
        */
        DB::statement("SET SQL_MODE=''");
        //$currentDate = "2021-05-08";
        $currentDate = $request->input('currentDate');

        $properties = Properties::select('idProperty', 'propertyName', 'propertyAmount', 'propertyAbility', 'images.imageLink', 'propertydescription', 'status_properties.status', 'propertyCity')
            ->join(DB::raw('(SELECT * FROM images GROUP BY property_id) as images'), function ($join) {
                $join->on('properties.idProperty', '=', 'images.property_id');
            })
            ->leftJoin('status_properties', 'status_properties.property_id', '=', 'properties.idProperty')
            ->where(function ($query) use ($currentDate) {
                $query->whereNull('status_properties.startDate')
                    ->orWhere('status_properties.startDate', '>', $currentDate);
            })
            ->orWhere(function ($query) use ($currentDate) {
                $query->whereNull('status_properties.endDate')
                    ->orWhere('status_properties.endDate', '<', $currentDate);
            })
            ->orWhere(function ($query) use ($currentDate) {
                $query->where('status_properties.status', '!=', 'Pausado')
                    ->orWhereNull('status_properties.status');
            })
            ->get();

        return response()->json($properties);
    }

    public function getUserPosts($id)
    {
        DB::statement("SET SQL_MODE=''");

        $properties = Properties::select('idProperty', 'propertyName', 'propertyAmount', 'propertyAbility', 'images.imageLink', 'host_id', 'propertydescription')
            ->join(DB::raw('(SELECT * FROM images GROUP BY property_id) as images'), function ($join) {
                $join->on('properties.idProperty', '=', 'images.property_id');
            })
            ->where('host_id', $id)
            ->get();

        return response()->json($properties);
    }


    public function propertiesById($id)
    {

        $properties = DB::table('properties')
            ->leftJoin('users', 'users.idUser', '=', 'properties.host_id')
            ->where('idProperty', '=', $id)
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
                'properties.propertyOperation',
                'properties.propertyType',
                'properties.propertyAddress',
                'properties.propertyDescription',
                'properties.propertyServices',
                'properties.propertyStatus',
                'properties.propertyAmount',
                'properties.propertyAbility',
                'properties.propertyCity',
                'propertyCroquis',
                'propertyRooms',
                'propertyBathrooms',
                'propertyBeds',
                'propertyRules',
                'propertySecurity',
                'properties.host_id',
            )
            ->get();

        $services = DB::table('properties')
            ->leftJoin('users', 'users.idUser', '=', 'properties.host_id')
            ->where('idProperty', '=', $id)->select('propertyServices')->get();


        $servicesArray = [];

        foreach ($services as $service) {
            $propertyServices = $service->propertyServices;

            $servicesList = explode(', ', $propertyServices);

            foreach ($servicesList as $singleService) {
                $servicesArray[] = ['service' => $singleService];
            }
        }

        $images = DB::table('images')
            ->where('property_id', $id)
            ->select('imageLink', 'imageDescription')
            ->get();

        return response()->json([
            'properties' => $properties,
            'Images' => $images,
            'sevices' => $servicesArray
        ]);
        //return $properties;
    }


    public function updateProperties(Request $request, $id)
    {
        try {
            $properties = properties::find($id);
            if (!$properties) {
                return response()->json(['error' => 'Property not found'], 404);
            }
            $properties->propertyName = $request->propertyName;
            $properties->propertyOperation = $request->propertyOperation;
            $properties->propertyType = $request->propertyType;
            $properties->propertyAddress = $request->propertyAddress;
            $properties->propertyDescription = $request->propertyDescription;
            $properties->propertyServices = $request->propertyServices;
            $properties->propertyStatus = $request->propertyStatus;
            $properties->propertyAmount = $request->propertyAmount;
            $properties->propertyAbility = $request->propertyAbility;
            $properties->propertyCity = $request->propertyCity;
            $properties->propertyCroquis = $request->propertyCroquis;
            $properties->propertyRooms = $request->propertyRooms;
            $properties->propertyBathrooms = $request->propertyBathrooms;
            $properties->propertyBeds = $request->propertyBeds;
            $properties->propertyRules = $request->propertyRules;
            $properties->propertySecurity = $request->propertySecurity;

            $properties->save();

            return $properties;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
