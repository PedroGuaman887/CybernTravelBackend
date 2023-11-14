<?php

namespace App\Http\Controllers;


use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ImagesController extends Controller
{
    public function createdImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'imageLink' => 'required|string|min:0',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $images = new images([

            'imageLink' => $request->imageLink,
            'imageDescription' => $request->imageDescription,

        ]);
        $images->property_id = $request->property_id;

        $images->save();


        $imagesId = $images->idImages;

        $property = $request->input('property');

        if (!is_array($property)) {
            return response()->json([
                'message' => 'El campo images debe ser un array válido.',
            ], 400);
        }

        return response()->json([
            'message' => 'User successfully images',
            'images' => $images,
            'properties' => $property,
        ], 201);
    }

    public function imagesById(Request $request)
    {
        $images = DB::table('images')
            ->leftJoin('properties', 'properties.idProperty', '=', 'images.property_id')
            ->where('property_id', '=', $request->idImages)
            ->where(function ($query) {
                $query->whereNull('images.property_id')
                    ->orWhereNotNull('images.property_id');
            })
            ->select(
                'images.idImages',
                'images.imageLink',
                'images.imageDescription',

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
                'properties.propertyCity',
                'properties.host_id',
            )
            ->get();

        return $images;
    }

    public function updateImages(Request $request, $id)
    {
        $images = Images::find($id);

        $images->imageLink = $request->imageLink;
        $images->imageDescription = $request->imageDescription;

        $images->save();
        return $images;
    }

    public function deleteImages(Request $request)
    {
        $deleted = Images::destroy($request->idImages);

        if ($deleted) {
            return response()->json(['message' => 'image removed']);
        } else {
            return response()->json(['message' => 'there is no image'], 404);
        }
    }
}
