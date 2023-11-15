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
    /* public function getAllPropertieswhitCity($city, $hosts)
    {
        DB::statement("SET SQL_MODE=''");

        $properties = Properties::select('idProperty', 'propertyName', 'propertyAmount', 'propertyAbility', 'images.imageLink', 'images.property_id', 'propertydescription', 'propertyCity', 'propertyStatus')
            ->join(DB::raw('(SELECT * FROM images GROUP BY property_id) as images'), function ($join) {
                $join->on('properties.idProperty', '=', 'images.property_id');
            })
            ->where('propertycity', 'LIKE', '%' . $city . '%')
            ->where('propertyStatus', 'disponible')
            ->where('propertyAbility', $hosts)
            //->whereBetween('fecha', ['2022-01-01', '2022-01-31'])
            ->get();

        return response()->json($properties);
    } */
    public function getAllPropertiesWithCity(Request $request)
    {

        DB::statement("SET SQL_MODE=''");
        $city = $request->input('city');
        $hosts = $request->input('hosts');
        // Verificar si tanto $city como $hosts están vacíos
        if (empty($city) && empty($hosts)) {
            return response()->json(['error' => 'City and hosts cannot be empty']);
        }

        // Verificar si solo $city está vacío
        if (empty($city)) {
            // Si $city está vacío pero $hosts tiene valor, filtrar solo por $hosts
            $properties = Properties::select('idProperty', 'propertyName', 'propertyAmount', 'propertyAbility', 'images.imageLink', 'images.property_id', 'propertydescription', 'propertyCity', 'propertyStatus')
                ->join(DB::raw('(SELECT * FROM images GROUP BY property_id) as images'), function ($join) {
                    $join->on('properties.idProperty', '=', 'images.property_id');
                })
                ->where('propertyStatus', 'disponible')
                ->where('propertyAbility', $hosts)
                //->whereBetween('fecha', ['2022-01-01', '2022-01-31'])
                ->get();

            return response()->json($properties);
        }

        // Verificar si solo $hosts está vacío
        if (empty($hosts)) {
            // Obtener todas las propiedades sin considerar hosts
            $properties = Properties::select('idProperty', 'propertyName', 'propertyAmount', 'propertyAbility', 'images.imageLink', 'images.property_id', 'propertydescription', 'propertyCity', 'propertyStatus')
                ->join(DB::raw('(SELECT * FROM images GROUP BY property_id) as images'), function ($join) {
                    $join->on('properties.idProperty', '=', 'images.property_id');
                })
                ->where('propertycity', 'LIKE', '%' . $city . '%')
                ->where('propertyStatus', 'disponible')
                //->whereBetween('fecha', ['2022-01-01', '2022-01-31'])
                ->get();

            return response()->json($properties);
        }

        // Si ambos $city y $hosts tienen valores, filtrar por ambas condiciones
        $properties = Properties::select('idProperty', 'propertyName', 'propertyAmount', 'propertyAbility', 'images.imageLink', 'images.property_id', 'propertydescription', 'propertyCity', 'propertyStatus')
            ->join(DB::raw('(SELECT * FROM images GROUP BY property_id) as images'), function ($join) {
                $join->on('properties.idProperty', '=', 'images.property_id');
            })
            ->where('propertycity', 'LIKE', '%' . $city . '%')
            ->where('propertyStatus', 'disponible')
            ->where('propertyAbility', $hosts)
            //->whereBetween('fecha', ['2022-01-01', '2022-01-31'])
            ->get();

        return response()->json($properties);
    }
}
