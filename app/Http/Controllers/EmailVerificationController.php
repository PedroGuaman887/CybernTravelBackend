<?php

namespace App\Http\Controllers;

use App\Models\User;

class EmailVerificationController extends Controller
{


    public function verify($id)
    {
        $user = User::find($id);

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'El correo ya ha sido verificado.'], 200);
        }

        if ($user->email_verified_at == null) {
            $user->email_verified_at = now();
            $user->save();
        }
        return redirect('/')->with('verified', true);
    }
}
