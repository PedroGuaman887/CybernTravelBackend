<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\Qualification;
use App\Models\Ratings;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class QualificationController extends Controller
{

    public function getQualificationsAndComments($idProperty)
    {
        $property = Properties::find($idProperty);

        $host = User::where('idUser', $property->host_id)->first();

        $qualification = Qualification::where('idUser', $host->idUser)->first();

        $comments = Ratings::select('ratingComment', 'idProperty', 'idUser', 'created_at')
            ->where('idProperty', $idProperty)
            ->whereNotNull('ratingComment')
            ->get();

        foreach ($comments as $comment) {
            $user = User::where('idUser', $comment->idUser)->first();
            $comment->userName = $user->fullName;
        }

        return response()->json([
            'host' => $host,
            'qualification' => $qualification,
            'comments' => $comments
        ], 201);
    }
    public function getPerfilHost($idUser)
    {

        $host = User::where('idUser', $idUser)->first();

        $qualification = Qualification::where('idUser', $host->idUser)->first();


        return response()->json([
            'host' => $host,
            'qualification' => $qualification,
        ], 201);
    }

    public function updateUserPicture(Request $request)
    {
        $user = User::find($request->idUser);

        if (!$user) {
            return response()->json(['error' => 'Property not found'], 404);
        }
        $user->user_picture = $request->user_picture;
        $user->save();
        return response()->json('user photo successfully updated');
    }
}
