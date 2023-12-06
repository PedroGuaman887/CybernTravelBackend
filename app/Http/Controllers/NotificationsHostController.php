<?php

namespace App\Http\Controllers;
use App\Models\NotificationsHosts;
use App\Models\Properties;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class NotificationsHostController extends Controller
{
    public function createdNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startDate' => 'date_format:Y-m-d',
            'endDate' => 'date_format:Y-m-d',
            'nameProperty' => 'required|string',
            'nameUser' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $newNotification = new NotificationsHosts([
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'nameProperty' => $request->nameProperty,
            'nameUser' => $request->nameUser,
        ]);

        $newNotification->idProperty = $request->idProperty;
        $newNotification->idUser = $request->idUser;

        $newNotification->save();

        return response()->json([
            'message' => 'User successfully notification host',
            'notificationHost' => $newNotification,
        ], 201);
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
