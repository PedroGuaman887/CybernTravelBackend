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

        $favorites = new Favorites([

            'dateSaved' => $request->dateSaved,

        ]);
        $favorites->property_id = $request->property_id;
        $favorites->user_id = $request->user_id;

        $favorites->save();

        return response()->json([
            'message' => 'Favorite registered successfully',
            'favorites' => $favorites,
        ], 201);
    }

    public function favoritesOfUser($user_id)
    {
        $favorites = DB::table('favorites')
            ->leftJoin('users', 'users.idUser', '=', 'favorites.user_id')
        ->leftJoin('properties', 'properties.idProperty', '=', 'favorites.property_id')
            ->where('favorites.user_id', '=', $user_id)
            ->where(function ($query) {
                $query->whereNull('favorites.user_id')
                    ->orWhereNotNull('favorites.user_id');
            })
            ->select(
                'favorites.idFavorites', 
                'favorites.dateSaved',

                'users.idUser',
                'users.fullName',
                'users.email',
                'users.phoneNumber',
                'users.birthDate',
                
                'properties.idProperty',
                'properties.propertyName',
                'properties.propertyOperation',
                'properties.propertyType',
                'properties.propertyAddress',
                'properties.propertyDescription',
                'properties.propertyServices',
                'properties.propertyStatus',
                'properties.propertyAmount',
                'properties.propertyAbility',
                'properties.propertyCity',)
            ->get();

        return $favorites;
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
