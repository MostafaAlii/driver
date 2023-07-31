<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneBoundResources;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\ZoneBound;
use Illuminate\Http\Request;

class ZoneBoundController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            return $this->successResponse(ZoneBoundResources::collection(ZoneBound::all()), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse(new ZoneBoundResources(ZoneBound::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'north'=> 'required',
            'east'=> 'required',
            'south'=> 'required',
            'west'=> 'required',
        ]);

        try {
            $data = ZoneBound::create([
                'zone_id' => $request->zone_id ?? null,
                'north' => $request->north ?? null,
                'east' => $request->east ?? null,
                'south' => $request->south ?? null,
                'west' => $request->west ?? null,


            ]);

            return $this->successResponse(new ZoneBoundResources($data), 'data Created Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'north'=> 'required',
            'east'=> 'required',
            'south'=> 'required',
            'west'=> 'required',
        ]);

        try {
            $data = ZoneBound::findorfail($id);
            $data->update([
                'zone_id' => $request->zone_id ?? $data->zone_id,
                'north' => $request->north ?? $data->north,
                'east' => $request->east ?? $data->east,
                'south' => $request->south ?? $data->south,
                'west' => $request->west ?? $data->west,
            ]);

            return $this->successResponse(new ZoneBoundResources($data), 'data Updated Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function deleted($id)
    {
        try {
            ZoneBound::destroy($id);
            return $this->successResponse(null, 'data Deleted Successfully');

        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }

    }
}
