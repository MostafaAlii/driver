<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneTypeResources;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\ZoneTypes;
use Illuminate\Http\Request;

class ZoneTypeController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            return $this->successResponse(ZoneTypeResources::collection(ZoneTypes::all()), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse(new ZoneTypeResources(ZoneTypes::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'vehicle_type_id' => 'required|exists:zones,id',
            'bill_status'=> 'required',
            'payment_type'=> 'required',
            'status'=> 'required|boolean',

        ]);

        try {
            $data = ZoneTypes::create([
                'zone_id' => $request->zone_id ?? null,
                'vehicle_type_id' => $request->vehicle_type_id ?? null,
                'bill_status' => $request->bill_status ?? null,
                'payment_type' => $request->payment_type ?? null,
                'status' => $request->status ?? null,


            ]);

            return $this->successResponse(new ZoneTypeResources($data), 'data Created Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'bill_status'=> 'required',
            'payment_type'=> 'required',
            'status'=> 'required|boolean',
        ]);

        try {
            $data = ZoneTypes::findorfail($id);
            $data->update([
                'zone_id' => $request->zone_id ?? $data->zone_id,
                'vehicle_type_id' => $request->vehicle_type_id ?? $data->vehicle_type_id,
                'bill_status' => $request->bill_status ?? $data->bill_status,
                'payment_type' => $request->payment_type ?? $data->payment_type,
                'status' => $request->status ?? $data->status,
            ]);

            return $this->successResponse(new ZoneTypeResources($data), 'data Updated Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function deleted($id)
    {
        try {
            ZoneTypes::destroy($id);
            return $this->successResponse(null, 'data Deleted Successfully');

        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }

    }
}
