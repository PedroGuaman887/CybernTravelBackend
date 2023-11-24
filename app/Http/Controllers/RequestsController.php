<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RequestsController extends Controller
{
    public function createdRequests(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'startDate' => 'date_format:Y-m-d',
            //'endDate' => 'date_format:Y-m-d',
            //'dateRequest' => 'date_format:Y-m-d',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $newRequests = new requests([

            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'dateRequest' => $request->dateRequest,
            'status' => $request->status,
            'idProperty' => $request->idProperty,
            'idUser' => $request->idUser,

        ]);


        return response()->json([
            'message' => 'User successfully request',
            'requests' => $newRequests,
        ], 201);
    }

    public function updateRequests(Request $request, $id)
    {
        $requests = requests::find($id);

        $requests->startDate = $request->startDate;
        $requests->endDate = $request->endDate;
        $requests->dateRequest = $request->dateRequest;
        $requests->status = $request->status;
        
        $requests->save();
        return $requests;
    }

    public function deleteRequests(Request $request)
    {
        $deleted = requests::destroy($request->idRequests);

        if ($deleted) {
            return response()->json(['message' => 'Requests removed']);
        } else {
            return response()->json(['message' => 'there is no Requests'], 404);
        }
    }

    public function requestsById(Request $request)
    {   //
        $requests = DB::table('requests')
            ->leftJoin('users', 'users.idUser', '=', 'requests.idUser')
            ->leftJoin('properties', 'properties.idProperty', '=', 'requests.idProperty')
            ->where('requests.idRequests', '=', $request->idRequests)
            ->where(function ($query) {
                $query->whereNull('requests.idRequests')
                    ->orWhereNotNull('requests.idRequests');
            })
            ->select(
                'requests.idRequests',
                'requests.startDate', 
                'requests.endDate',
                'requests.dateRequest', 
                'requests.status', 

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

        return $requests;
    }

    public function getAllRequests()
    {
        $requests = requests::all();

        foreach ($requests as $request) {

            if ($request->idUser !== null) {
                $user = users::find($request->idUser);
                $request->user = [
                    'idUser' => $user->idUser,
                    'fullName' => $user->fullName,
                    'email' => $user->email,
                    'phoneNumber' => $user->phoneNumber,
                    'birthDate' => $user->birthDate
                ];
            }

            if ($request->idSitio !== null) {
                $propertie = properties::find($request->idProperty);
                $request->propertie = [
                    'idProperty' => $propertie->idProperty,
                    'propertyName' => $propertie->propertyName,
                    'propertyOperation' => $propertie->propertyOperation,
                    'propertyType' => $propertie->propertyType,
                    'propertyAddress' => $propertie->propertyAddress,
                    'propertyDescription' => $propertie->propertyDescription,
                    'propertyServices' => $propertie->propertyServices,
                    'propertyStatus' => $propertie->propertyStatus,
                    'propertyAmount' => $propertie->propertyAmount,
                    'propertyAbility' => $propertie->propertyAbility,
                    'propertyCity' => $propertie->propertyCity,
                    'propertyCroquis' => $propertie->propertyCroquis,
                    'propertyRooms' => $propertie->propertyRooms,
                    'propertyBathrooms' => $propertie->propertyBathrooms,
                    'propertyBeds' => $propertie->propertyBeds,
                    'propertyRules' => $propertie->propertyRules,
                    'propertySecurity' => $propertie->propertySecurity
                ];
            }
        }

        return $requests;
    }
}
