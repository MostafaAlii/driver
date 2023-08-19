<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarTypeResource;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\CarType;
use Illuminate\Http\Request;
class CarTypeController extends Controller{
    use ApiResponseTrait;
    public function index(){
        try {
            return $this->successResponse(CarTypeResource::collection(CarType::active()), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }
}