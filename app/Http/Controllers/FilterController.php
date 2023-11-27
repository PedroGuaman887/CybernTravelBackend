<?php

namespace App\Http\Controllers;

use App\Models\Holidays;
use App\Models\Images;
use App\Models\Properties;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function getAllPropertiesWithCity(Request $request)
    {

        DB::statement("SET SQL_MODE=''");
        $city = $request->input('city');
        $hosts = $request->input('hosts');
        if (empty($city) && empty($hosts)) {
            return response()->json(['error' => 'City and hosts cannot be empty']);
        }

        if (empty($city)) {
            $properties = Properties::select('idProperty', 'propertyName', 'propertyAmount', 'propertyAbility', 'images.imageLink', 'images.property_id', 'propertyDescription', 'propertyCity', 'propertyStatus')
                ->join(DB::raw('(SELECT * FROM images GROUP BY property_id) as images'), function ($join) {
                    $join->on('properties.idProperty', '=', 'images.property_id');
                })
                ->where('propertyStatus', 'disponible')
                ->where('propertyAbility', $hosts)
                //->whereBetween('fecha', ['2022-01-01', '2022-01-31'])
                ->get();

            return response()->json($properties);
        }

        if (empty($hosts)) {
            $properties = Properties::select('idProperty', 'propertyName', 'propertyAmount', 'propertyAbility', 'images.imageLink', 'images.property_id', 'propertyDescription', 'propertyCity', 'propertyStatus')
                ->join(DB::raw('(SELECT * FROM images GROUP BY property_id) as images'), function ($join) {
                    $join->on('properties.idProperty', '=', 'images.property_id');
                })
                ->where('propertycity', 'LIKE', '%' . $city . '%')
                ->where('propertyStatus', 'disponible')
                //->whereBetween('fecha', ['2022-01-01', '2022-01-31'])
                ->get();

            return response()->json($properties);
        }

        $properties = Properties::select('idProperty', 'propertyName', 'propertyAmount', 'propertyAbility', 'images.imageLink', 'images.property_id', 'propertyDescription', 'propertyCity', 'propertyStatus')
            ->join(DB::raw('(SELECT * FROM images GROUP BY property_id) as images'), function ($join) {
                $join->on('properties.idProperty', '=', 'images.property_id');
            })
            ->where('propertycity', 'LIKE', '%' . $city . '%')
            ->where('propertyStatus', 'Publicado')
            ->where('propertyAbility', $hosts)
            //->whereBetween('fecha', ['2022-01-01', '2022-01-31'])
            ->get();

        return response()->json($properties);
    }
}
