<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PropertiesController extends Controller
{
    public function createdProperties(Request $request)
    {
        $validator = Validator::make($request->all(), [  //valida los maximos y
            'propertyName' => 'required|string|min:1|max:500',
            'propertyPicture' => 'required|string|min:1|max:500',
            'propertyOperation' => 'required|string|min:1|max:500',
            'propertyType' => 'required|string|min:1|max:500',
            'propertyAddress' => 'required|string|min:1|max:500',
            'propertyDescription' => 'required|string|min:1|max:500',
            'propertyServices' => 'required|string|min:1|max:500',
            'propertyStatus' => 'required|string|min:1|max:500',
            'propertyAmount' => 'required|integer|min:0',
            'propertyAbility' => 'required|integer|min:0',
            'propertyStartA' => 'date_format:Y-m-d',
            'propertyEndA' => 'date_format:Y-m-d',
            'propertyStartB' => 'date_format:Y-m-d',
            'propertyEndB' => 'date_format:Y-m-d',
            'propertyStartC' => 'date_format:Y-m-d',
            'propertyEndC' => 'date_format:Y-m-d',
            'propertyStartD' => 'date_format:Y-m-d',
            'propertyEndD' => 'date_format:Y-m-d',
            'propertyStartE' => 'date_format:Y-m-d',
            'propertyEndE' => 'date_format:Y-m-d',
            'propertyStartF' => 'date_format:Y-m-d',
            'propertyEndF' => 'date_format:Y-m-d',
            'propertyStartG' => 'date_format:Y-m-d',
            'propertyEndG' => 'date_format:Y-m-d',
            'propertyStartH' => 'date_format:Y-m-d',
            'propertyEndH' => 'date_format:Y-m-d',
            'propertyAmountA' => 'integer|min:0',
            'propertyAmountB' => 'integer|min:0',
            'propertyAmountC' => 'integer|min:0',
            'propertyAmountD' => 'integer|min:0',
            'propertyAmountE' => 'integer|min:0',
            'propertyAmountF' => 'integer|min:0',
            'propertyAmountG' => 'integer|min:0',
            'propertyAmountH' => 'integer|min:0',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $properties = new properties([
            'propertyName' => $request->propertyName,
            'propertyPicture' => $request->propertyPicture,
            'propertyOperation' => $request->propertyOperation,
            'propertyType' => $request->propertyType,
            'propertyAddress' => $request->propertyAddress,
            'propertyDescription' => $request->propertyDescription,
            'propertyServices' => $request->propertyServices,
            'propertyStatus' => $request->propertyStatus,
            'propertyAmount' => $request->propertyAmount,
            'propertyAbility' => $request->propertyAbility,
            'propertyStartA' => $request->propertyStartA,
            'propertyEndA' => $request->propertyEndA,
            'propertyStartB' => $request->propertyStartB,
            'propertyEndB' => $request->propertyEndB,
            'propertyStartC' => $request->propertyStartC,
            'propertyEndC' => $request->propertyEndC,
            'propertyStartD' => $request->propertyStartD,
            'propertyEndD' => $request->propertyEndD,
            'propertyStartE' => $request->propertyStartE,
            'propertyEndE' => $request->propertyEndE,
            'propertyStartF' => $request->propertyStartF,
            'propertyEndF' => $request->propertyEndF,
            'propertyStartG' => $request->propertyStartG,
            'propertyEndG' => $request->propertyEndG,
            'propertyStartH' => $request->propertyStartH,
            'propertyEndH' => $request->propertyEndH,
            'propertyAmountA' => $request->propertyAmountA,
            'propertyAmountB' => $request->propertyAmountB,
            'propertyAmountC' => $request->propertyAmountC,
            'propertyAmountD' => $request->propertyAmountD,
            'propertyAmountE' => $request->propertyAmountE,
            'propertyAmountF' => $request->propertyAmountF,
            'propertyAmountG' => $request->propertyAmountG,
            'propertyAmountH' => $request->propertyAmountH,
        ]);
        $properties->save();

        return response()->json([
            'message' => 'successful property registration.',
            'properties' => $properties,
        ], 201);
    }

    public function propertiesById(Request $request)
    {
        $properties = DB::table('properties')->where('idProperty', '=', $request->idProperty)
            ->select(
                'properties.idProperty',
                'properties.propertyName',
                'properties.propertyPicture',
                'properties.propertyOperation',
                'properties.propertyType',
                'properties.propertyAddress',
                'properties.propertyDescription',
                'properties.propertyServices',
                'properties.propertyStatus',
                'properties.propertyAmount',
                'properties.propertyAbility',
                'properties.propertyStartA',
                'properties.propertyEndA',
                'properties.propertyStartB',
                'properties.propertyEndB',
                'properties.propertyStartC',
                'properties.propertyEndC',
                'properties.propertyStartD',
                'properties.propertyEndD',
                'properties.propertyStartE',
                'properties.propertyEndE',
                'properties.propertyStartF',
                'properties.propertyEndF',
                'properties.propertyStartG',
                'properties.propertyEndG',
                'properties.propertyStartH',
                'properties.propertyEndH',
                'properties.propertyAmountA',
                'properties.propertyAmountB',
                'properties.propertyAmountC',
                'properties.propertyAmountD',
                'properties.propertyAmountE',
                'properties.propertyAmountF',
                'properties.propertyAmountG',
                'properties.propertyAmountH'
            )
            ->get();

        return $properties;
    }

    public function updateProperties(Request $request, $id)
    {
        $properties = properties::find($id);

        $properties->propertyName = $request->propertyName;
        $properties->propertyPicture = $request->propertyPicture;
        $properties->propertyOperation = $request->propertyOperation;
        $properties->propertyType = $request->propertyType;
        $properties->propertyAddress = $request->propertyAddress;
        $properties->propertyDescription = $request->propertyDescription;
        $properties->propertyServices = $request->propertyServices;
        $properties->propertyStatus = $request->propertyStatus;
        $properties->propertyAmount = $request->propertyAmount;
        $properties->propertyAbility = $request->propertyAbility;
        $properties->propertyStartA = $request->propertyStartA;
        $properties->propertyEndA = $request->propertyEndA;
        $properties->propertyStartB = $request->propertyStartB;
        $properties->propertyEndB = $request->propertyEndB;
        $properties->propertyStartC = $request->propertyStartC;
        $properties->propertyEndC = $request->propertyEndC;
        $properties->propertyStartD = $request->propertyStartD;
        $properties->propertyEndD = $request->propertyEndD;
        $properties->propertyStartE = $request->propertyStartE;
        $properties->propertyEndE = $request->propertyEndE;
        $properties->propertyStartF = $request->propertyStartF;
        $properties->propertyEndF = $request->propertyEndF;
        $properties->propertyStartG = $request->propertyStartG;
        $properties->propertyEndG = $request->propertyEndG;
        $properties->propertyStartH = $request->propertyStartH;
        $properties->propertyEndH = $request->propertyEndH;
        $properties->propertyAmountA = $request->propertyAmountA;
        $properties->propertyAmountB = $request->propertyAmountB;
        $properties->propertyAmountC = $request->propertyAmountC;
        $properties->propertyAmountD = $request->propertyAmountD;
        $properties->propertyAmountE = $request->propertyAmountE;
        $properties->propertyAmountF = $request->propertyAmountF;
        $properties->propertyAmountG = $request->propertyAmountG;
        $properties->propertyAmountH = $request->propertyAmountH;

        $properties->save();
        return $properties;
    }

    public function deleteProperties(Request $request)
    {
        $deleted = properties::destroy($request->idProperty);

        if ($deleted) {
            return response()->json(['message' => 'property removed']);
        } else {
            return response()->json(['message' => 'there is no property'], 404);
        }
    }
}
