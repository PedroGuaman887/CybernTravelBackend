<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function createdFavorites(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dateSaved' => 'required|string|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $favorites = new Favorites([

            'dateSaved' => $request->dateSaved,

        ]);
        $favorites->property_id = $request->property_id;
        $favorites->user_id = $request->user_id;

        $favorites->save();

        return response()->json([
            'message' => 'User successfully images',
            'favorites' => $favorites,
        ], 201);
    }

    public function destroy(Request $request)
    {
        $deleted = Favorites::destroy($request->idFavorites);

        if ($deleted) {
            return response()->json(['message' => 'Registro eliminado correctamente']);
        } else {
            return response()->json(['message' => 'No se encontró el registro'], 404);
        }
    }

}
