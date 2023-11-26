<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\Properties;
use App\Models\User;
use App\Models\Reservations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RequestsController extends Controller
{
    public function createdRequests(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startDate' => 'date_format:Y-m-d',
            'endDate' => 'date_format:Y-m-d',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Sumar un día a la fecha
        $dateRequest = Carbon::parse($request->dateRequest)->addDay();

        $newRequests = new Requests([
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'dateRequest' => $dateRequest,
            'status' => $request->status,
        ]);

        $newRequests->idProperty = $request->idProperty;
        $newRequests->idUser = $request->idUser;

        $newRequests->save();

        return response()->json([
            'message' => 'User successfully request',
            'requests' => $newRequests,
        ], 201);
    }

        public function updateRequests(Request $request, $id)
    {
        $requests = Requests::find($id);

        $requests->startDate = $request->startDate;
        $requests->endDate = $request->endDate;
        $requests->dateRequest = $request->dateRequest;
        $requests->status = $request->status;

        $requests->save();

        // Verificar si el estado es 'Pagado'
        if ($request->status === 'Pagado') {
            // Crear una nueva reserva
            $newReservation = new Reservations([
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'datePayment' => now(), // Puedes ajustar esto según tu lógica
                'status' => 'nueva', // Iniciar el estado con 'nueva'
                'idRequests' => $id, // Utilizar el ID de la solicitud actual
            ]);

            $newReservation->save();

            return response()->json([
                'message' => 'User successfully updated and reservation created',
                'requests' => $requests,
                'reservation' => $newReservation,
            ], 201);
        }

        return response()->json([
            'message' => 'User successfully updated, but no reservation created',
            'requests' => $requests,
        ], 200);
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
