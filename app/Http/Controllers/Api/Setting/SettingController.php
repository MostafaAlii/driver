<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverActivityResources;
use App\Http\Resources\Drivers\DriverResources;
use App\Http\Resources\Users\UserResources;
use App\Http\Traits\Api\ApiResponseTrait;
use App\Models\Driver;
use App\Models\DriverActivity;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    use ApiResponseTrait;

    public function checkExisting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:user,driver',
            'status' => 'required|in:email,phone',
            'data' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        try {
            $type = $request->type;
            $status = $request->status;
            $data = $request->data;

            if ($type == 'user') {
                $findUser = $status == 'email' ? User::where('email', $data)->first() : User::where('phone', $data)->first();
                if ($findUser) {
                    return $this->successResponse(new UserResources($findUser), 'Data returned successfully');
                } else {
                    return $this->errorResponse('The ' . ucfirst($status) . ' User Not Found');
                }
            } else {
                $findDriver = $status == 'email' ? Driver::where('email', $data)->first() : Driver::where('phone', $data)->first();
                if ($findDriver) {
                    return $this->successResponse(new DriverResources($findDriver), 'Data returned successfully');
                } else {
                    return $this->errorResponse('The ' . ucfirst($status) . ' Driver Not Found');
                }
            }
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }


    public function driver_online()
    {
        try {

            return $this->successResponse(DriverActivity::where('type','online')->paginate(50), 'Data returned successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }

    }

    public function driver_closest(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        try {
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            $radius = Settings::first()->ocean ?? 10; // قطر البحث بالكيلومترات

            $captains = DriverActivity::where('type','online')->selectRaw("
            *,
            (6371 * acos(cos(radians($latitude)) * cos(radians(lat)) * cos(radians(lan) - radians($longitude)) + sin(radians($latitude)) * sin(radians(lat)))) AS distance
      ")
                ->having('distance', '<', $radius)
                ->orderBy('distance')
                ->get();

            return $this->successResponse(DriverActivityResources::collection($captains), 'Data returned successfully');

        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }



    }



}
