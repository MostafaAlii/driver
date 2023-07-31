<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleTypeResources;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\VehicleTypes;
use Illuminate\Http\Request;

class vehicleTypeController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            return $this->successResponse(VehicleTypeResources::collection(VehicleTypes::all()), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show($id)
    {
        try {
            return $this->successResponse(new VehicleTypeResources(VehicleTypes::findorfail($id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }
}
