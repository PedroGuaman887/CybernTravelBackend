<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\Qualification;
use App\Models\Qualifications_user;
use App\Models\User;
use App\Models\Users_comments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class QualificationsUserController extends Controller
{
    public function rateToUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ratingCleaning' => 'required|integer',
            'ratingPunctuality' => 'required|integer',
            'ratingFriendliness' => 'required|integer',
            'commentToUser' => 'required',
            'idHost' => 'required|integer',
            'idUser' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $existingQualification = Qualifications_user::where('idUser', $request->idUser)->first();

        if ($existingQualification) {
            $existingQualification->ratingCleaning += $request->ratingCleaning;
            $existingQualification->ratingPunctuality += $request->ratingPunctuality;
            $existingQualification->ratingComunication += $request->ratingFriendliness;
            $existingQualification->qualificationAmount += 1;
            $existingQualification->save();
            $qualification = $existingQualification;
        } else {
            $qualification = new Qualifications_user([
                'ratingCleaning' => $request->ratingCleaning,
                'ratingPunctuality' => $request->ratingPunctuality,
                'ratingComunication' => $request->ratingFriendliness,
                'qualificationAmount' => 1,
            ]);

            $qualification->idUser = $request->idUser;
            $qualification->save();
        }

        $currentDate = Carbon::now()->format('y-m-d');
        $comment = new Users_comments([
            'comment' => $request->commentToUser,
            'commentDate' => $currentDate
        ]);
        $comment->sender_user_id = $request->idHost;
        $comment->receiver_user_id = $request->idUser;
        $comment->save();

        return response()->json([
            'message' => 'Successful user rating',
            'qualification' => $qualification,
            'comment' => $comment,
        ], 201);
    }
    public function getPerfilUSer($idUser)
    {
        DB::statement("SET SQL_MODE=''");

        $host = User::where('idUser', $idUser)->first();

        $qualification = Qualification::select('idQualification', 'ratingCleaning', 'ratingPunctuality', 'ratingComunication', 'qualificationAmount', 'idUser')
            ->where('idUser', $host->idUser)->first();

        $qualification_user = Qualifications_user::select('idQualificationUser', 'ratingCleaning', 'ratingPunctuality', 'ratingComunication', 'qualificationAmount', 'idUser')
            ->where('idUser', $host->idUser)->first();

        $comments_user = Users_comments::where('receiver_user_id', $idUser)->get();

        foreach ($comments_user as $comment) {
            $senderUser = User::find($comment->sender_user_id);
            $comment->senderUserName = $senderUser ? $senderUser->fullName : null;
        }

        $comments_host = Users_comments::where('sender_user_id', $idUser)->get();

        foreach ($comments_host as $comment) {
            $senderUser = User::find($comment->sender_user_id);
            $comment->senderUserName = $senderUser ? $senderUser->fullName : null;
        }

        $properties = Properties::select(
            'idProperty',
            'propertyName',
            'propertyAbility',
            'images.imageLink',
            'propertyCity',
            'propertyStatus',
            'status_properties.status',
            'status_properties.startDate',
            'status_properties.endDate',
        )->join(DB::raw('(SELECT * FROM images GROUP BY property_id) as images'), function ($join) {
            $join->on('properties.idProperty', '=', 'images.property_id');
        })
            ->leftJoin('status_properties', 'status_properties.property_id', '=', 'properties.idProperty')
            ->where('propertyStatus', 'Publicado')
            ->get();

        $filteredProperties = $properties->reject(function ($property) {
            return $property->status === 'Pausado';
        });

        $filteredPropertiesArray = $filteredProperties->toArray();

        return response()->json([
            'host' => $host,
            'host qualification' => $qualification,
            'user qualification' => $qualification_user,
            'user posts' => $filteredPropertiesArray,
            'comments from users to the host' => $comments_user,
            'comments from hosts to the user' => $comments_host
        ], 201);
    }
}
