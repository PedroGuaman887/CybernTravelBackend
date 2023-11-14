<?php

namespace App\Http\Controllers;

use App\Models\Holidays;
use App\Models\Properties;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HolidaysController extends Controller
{
    public function createdHolidays(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'startDate' => 'date_format:Y-m-d',
            //'endDate' => 'date_format:Y-m-d', 
            'amount' => 'required|integer|min:0',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $holidays = new holidays([

            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);
        $holidays->property_id = $request->property_id;

        $holidays->save();


        /*$holidaysId = $holidays->idHolidays;

        $property = $request->input('property');

        if (!is_array($property)) {
            return response()->json([
                'message' => 'El campo holidays debe ser un array válido.',
            ], 400);
        }*/

        return response()->json([
            'message' => 'User successfully holidays',
            'holidays' => $holidays,
            //'properties' => $property,
        ], 201);
    }

    public function holidaysById(Request $request)
    {
        $holidays = DB::table('holidays')
            ->leftJoin('properties', 'properties.idProperty', '=', 'holidays.property_id')
            ->where('idHolidays', '=', $request->idHolidays)
            ->where(function ($query) {
                $query->whereNull('holidays.property_id')
                    ->orWhereNotNull('holidays.property_id');
            })
            ->select(
                'holidays.idHolidays',
                'holidays.startDate',
                'holidays.endDate',
                'holidays.amount',
                'holidays.status',

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
                'properties.host_id',
            )
            ->get();

        return $holidays;
    }

    public function updateHolidays(Request $request, $id)
    {
        $holidays = holidays::find($id);

        $holidays->startDate = $request->startDate;
        $holidays->endDate = $request->endDate;
        $holidays->amount = $request->amount;
        $holidays->status = $request->status;

        $holidays->save();
        return $holidays;
    }

    public function deleteHolidays(Request $request)
    {
        $deleted = holidays::destroy($request->idHolidays);

        if ($deleted) {
            return response()->json(['message' => 'holidays removed']);
        } else {
            return response()->json(['message' => 'there is no holidays'], 404);
        }
    }
}
