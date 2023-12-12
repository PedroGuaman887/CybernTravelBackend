<?php

namespace App\Http\Controllers;

use App\Models\Qualification;
use App\Models\Qualifications_user;
use App\Models\User;
use App\Models\Users_comments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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

        $host = User::where('idUser', $idUser)->first();

        $qualification = Qualification::where('idUser', $host->idUser)->first();

        $comments = Users_comments::where('receiver_user_id', $idUser)->get();

        foreach ($comments as $comment) {
            $senderUser = User::find($comment->sender_user_id);
            $comment->senderUserName = $senderUser ? $senderUser->fullName : null;
        }

        return response()->json([
            'host' => $host,
            'qualification' => $qualification,
            'comments' => $comments
        ], 201);
    }
}
