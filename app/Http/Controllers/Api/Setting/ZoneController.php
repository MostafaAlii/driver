<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneResources;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            return $this->successResponse(ZoneResources::collection(Zone::all()), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse(new ZoneResources(Zone::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'service_location_id' => 'required|exists:service_locations,id',
            'name' => 'required|string',
            'unit' => 'required|string',
            'coordinates' => 'nullable'
        ]);

        try {
            $data = Zone::create([
                'service_location_id' => $request->service_location_id ?? null,
                'name' => $request->name ?? null,
                'unit' => $request->unit ?? null,
                'coordinates' => $request->coordinates ?? null,
                'status' => true ?? null,
            ]);

            return $this->successResponse(new ZoneResources($data), 'data Created Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'service_location_id' => 'required|exists:service_locations,id',
            'name' => 'required|string',
            'unit' => 'required|string',
            'coordinates' => 'nullable'
        ]);

        try {
            $data = Zone::findorfail($id);
            $data->update([
                'service_location_id' => $request->service_location_id ?? $data->service_location_id,
                'name' => $request->name ?? $data->name,
                'unit' => $request->unit ?? $data->unit,
                'coordinates' => $request->coordinates ?? $data->coordinates,
                'status' => $request->status ?? $data->status,
            ]);

            return $this->successResponse(new ZoneResources($data), 'data Updated Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function deleted($id)
    {
        try {
            Zone::destroy($id);
            return $this->successResponse(null, 'data Deleted Successfully');

        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }

    }
}
