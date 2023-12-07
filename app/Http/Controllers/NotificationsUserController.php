<?php

namespace App\Http\Controllers;

use App\Models\NotificationsUsers;
use App\Models\Properties;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NotificationsUserController extends Controller
{
    public function createdNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phoneHost' => 'required|string',
            'nameProperty' => 'required|string',
            'nameHost' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $newNotification = new NotificationsUsers([
            'phoneHost' => $request->phoneHost,
            'nameProperty' => $request->nameProperty,
            'nameHost' => $request->nameHost,
        ]);

        $newNotification->idProperty = $request->idProperty;
        $newNotification->idUser = $request->idUser;

        $newNotification->save();

        return response()->json([
            'message' => 'User successfully notification user',
            'notificationUser' => $newNotification,
        ], 201);
    }


    public function userByUser(Request $request)
    {
        $user = DB::table('notifications_users')->where('idUser', '=', $request->idUser)
            ->select(
                'notifications_users.idNotificationsUsers',
                'notifications_users.nameProperty',
                'notifications_users.nameHost',
                'notifications_users.phoneHost',
                'notifications_users.idProperty',
                'notifications_users.idUser'
            )
            ->get();

        return $user;
    }
}
