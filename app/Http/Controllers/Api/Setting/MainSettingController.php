<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainSettingResources;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\Settings;
use Illuminate\Http\Request;

class MainSettingController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        try {
            return $this->successResponse(MainSettingResources::collection(Settings::get()), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }
}
