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
            'nameUser' => $request->nameUser,
        ]);

        $newNotification->idProperty = $request->idProperty;
        $newNotification->idUser = $request->idUser;

        $newNotification->save();

        return response()->json([
            'message' => 'User successfully notification user',
            'notificationUser' => $newNotification,
        ], 201);
    }
}
