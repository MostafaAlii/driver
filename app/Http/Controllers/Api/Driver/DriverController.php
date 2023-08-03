<?php

namespace App\Http\Controllers\Api\Driver;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Models\DriverProfile;
use App\Models\DriverActivity;
use App\Models\MediaFilesStatus;
use App\Models\DriverProfileMedia;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\Api\ApiResponseTrait;
use Illuminate\Support\Facades\Validator;
use App\Events\Api\CheckCodeVerifiedEvent;
use App\Http\Resources\DriverActivityResources;
use App\Http\Resources\Drivers\DriverResources;
use App\Http\Resources\Drivers\DriverProfileResources;

class DriverController extends Controller {
    use ApiResponseTrait;
    public function index() {
        try {
            return $this->successResponse(Driver::paginate(50), 'data Return Successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show_profile_driver(Request $request)
    {
        try {
            return $this->successResponse(new DriverResources(Driver::findorfail(auth('driver-api')->user()->id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Please Login First'], 401);
        }
    }


    public function verified(Request $request) {


        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $id = Driver::where('phone', $request->phone)->first();
        if (!$id) {
            return response()->json(['error' => 'The Driver Is not Find'], 401);
        }

        $checkUserIsNotVerified = Driver::findorfail($id->id);
        if (!empty($checkUserIsNotVerified->email_verified_at)) {
            return $this->successResponse('The Driver is already verified');

        } else {
            // Check Sms Code

            $data = [
                'user_type' => 'driver',
                'user_id' => $id->id,
                'phone' => $request->phone,
                'otp' => $request->otp,
            ];

            $event = event(new CheckCodeVerifiedEvent($data));
            return $this->successResponse($event[0]->original);
        }
    }


    public function driver_activity(Request $request) {
        $validator = Validator::make($request->all(), [
            //'driver_id' => 'required|exists:drivers,id',
            'lan' => 'required',
            'lat' => 'required',
            'type' => 'required|in:online,offline',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $driver = DriverActivity::where('driver_id', auth('driver-api')->id())->first();
        if ($driver){
            if ($driver->status == "inactive") {
                return $this->errorResponse('Your account has been suspended, please contact the administrator');
            }
        }



        try {
            $data = DriverActivity::updateOrCreate([
                'driver_id' => auth('driver-api')->id()
            ], [
                'driver_id' => auth('driver-api')->id(),
                'lan' => $request->lan,
                'lat' => $request->lat,
                'type' => $request->type,
            ]);

            return $this->successResponse(new DriverActivityResources($data), 'Successfully');
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Something went wrong, please try again !!'], 401);
        }


    }

    public function sendOtp(Request $request) {
        try {
            $phone = $request->input('phone');
            $otp = Driver::DRIVER_OTP;
            $driver = Driver::wherePhone($phone)->first();
            if (!$driver) 
                return response()->json(['error' => 'The Driver Is not Find'], 401);
            
            DB::table('driver_password_reset_tokens')->updateOrInsert(
                ['phone' => $phone],
                ['otp' => $otp, 'created_at' => now()]
            );
            return $this->successResponse($otp);

        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function resetPassword(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|numeric',
                'newPassword' => 'required|string|min:6',
            ]);
            if($validator->fails())
                return response()->json(array('error' => 'Weak Password'), 401);
            $driver = Driver::wherePhone($request->phone)->first();
            if (!$driver) 
                return $this->errorResponse('The Driver Is not Find');
            $token = DB::table('driver_password_reset_tokens')->wherePhone($request->phone)->first();
            if (!$token) 
                return $this->errorResponse('The Otp Code Is not Find');
            if ($token->otp != $token->otp) 
                return $this->errorResponse('The Otp Code Is not Correct');
            $driver->update(['password' => bcrypt($request->newPassword)]);
            DB::table('driver_password_reset_tokens')->wherePhone($request->phone)->delete();
            return $this->successResponse('The Password has been reset successfully for ' . $driver->name);
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function driver_profile_update(Request $request) {
        try{
            $driver = DriverProfile::where('driver_id', auth('driver-api')->id())->first();
            $validatedData = $request->validate([
                'bio' => 'sometimes|nullable|string',
                'vehicle_type_id' => 'sometimes|exists:vehicle_types,id',
                'car_make_id' => 'sometimes|exists:car_makes,id',
                'car_model_id' => 'sometimes|exists:car_models,id',
                'car_number' => 'sometimes|string',
                'car_color' => 'sometimes|string',
                'nationality_id' => 'sometimes|nullable|numeric',
                'avatar' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048', 
            ]);
            if($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = 'avatar.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('dashboard/images/driver_document/' . $driver->owner->email . $driver->owner->phone . '_' . $driver->uuid), $avatarName);
                $validatedData['avatar'] = $avatarName;
            }
            $driver->update($validatedData);
            return $this->successResponse(new DriverProfileResources($driver) , 'Data Return Successfully');
            return $this->successResponse('Data Return Successfully');
        } catch(\Exception $exception) {
            return response()->json(['error' => 'Something went wrong, please try again !!'], 401);
        }
    }

    public function uploadCarImages(Request $request) {
        try {
            $driver = DriverProfile::findOrFail(auth('driver-api')->id());
            $imageTypes = ['car_front_side', 'car_back_side', 'car_right_side', 'car_left_side', 'car_inside', 'car_plate'];
            $this->uploadImages($request, $driver, $imageTypes);
             return $this->successResponse('Car images uploaded successfully ' . $driver->owner->name);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function uploadPersonalImages(Request $request) {
        try {
            $driver = DriverProfile::findOrFail(auth('driver-api')->id());
            $imageTypes = ['personal_identification_front', 'personal_identification_back', 'criminal_record'];
            $this->uploadImages($request, $driver, $imageTypes);
            return $this->successResponse('Personal images uploaded successfully ' . $driver->owner->name);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function uploadLicense(Request $request) {
        try {
            $driver = DriverProfile::findOrFail(auth('driver-api')->id());
            $imageTypes = ['license_front', 'license_back', 'car_license_front', 'car_license_back'];
            $this->uploadImages($request, $driver, $imageTypes);
            return $this->successResponse('Driver and Car License uploaded successfully ' . $driver->owner->name);
        } catch (\Exception $e) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function checkProfileMedia(Request $request) {
        $driver = DriverProfile::where('driver_id', auth('driver-api')->id())->first();
        $driverProfileMedia = DriverProfileMedia::where('driver_profile_id', $driver->id)->first();
        $response = [];
        if (!$driverProfileMedia) {
            return $this->errorResponse('The Driver Profile Media Is not Find', 200);
        }
        $columns = array_diff($driverProfileMedia->getFillable(), ['driver_profile_id']);
        foreach ($columns as $column) {
            if (!$driverProfileMedia->{$column}) {
                return $this->errorResponse('The ' . $column . ' Is not Uploaded', 200);
            } else {
                $mediaFileStatus = MediaFilesStatus::where('driver_profiles_media_id', $driverProfileMedia->id)->where('type', $column)->first();
                if ($mediaFileStatus) {
                    $response[] = [
                        'type' => $column,
                        'status' => $mediaFileStatus->status,
                        'image' => $driverProfileMedia->{$column} ? asset('dashboard/images/driver_document/' . $driver->owner->email . $driver->owner->phone . '_' . $driver->uuid  . '/' . $driverProfileMedia->{$column}) : null,
                    ];
                } else {
                    return $this->errorResponse('No media file status found for ' . $column);
                }
            }
        }
        return $this->successResponse($response, 'Media files status retrieved successfully');
    }
    
    private function uploadImages(Request $request, DriverProfile $driver, array $imageTypes) {
        $driverProfileMedia = DriverProfileMedia::where('driver_profile_id', $driver->id)->firstOrNew();
        foreach ($imageTypes as $imageType) {
            if ($request->hasFile($imageType)) {
                $oldImageName = $driverProfileMedia->{$imageType};
                if ($oldImageName && Storage::exists('dashboard/images/driver_document/' . $driver->owner->name . '/' . $oldImageName))
                    Storage::delete('dashboard/images/driver_document/' . $driver->owner->name . '_' . $driver->uuid  . '/' . $oldImageName);
                $image = $request->file($imageType);
                $imageName =  $imageType . '.' . $image->getClientOriginalExtension();
                $image->storeAs('dashboard/images/driver_document/' . $driver->owner->email . $driver->owner->phone . '_' . $driver->uuid, $imageName, 'upload_attachments');
                $driverProfileMedia->{$imageType} = $imageName;
            }
        }
        $driverProfileMedia->driver_profile_id = $driver->id;
        $driverProfileMedia->save();
        foreach ($imageTypes as $imageType) {
            $status = 'not_active';
            if (!empty($driverProfileMedia->{$imageType})) {
                MediaFilesStatus::updateOrCreate(
                    [
                        'driver_profiles_media_id' => $driverProfileMedia->id,
                        'type' => $imageType,
                    ],
                    ['status' => $status]
                );
            }
        }
        return true;
    }

    
    public function getProfileInfo(Request $request) {
        $id = $request->input('id');
        $type = $request->input('type');
        if ($type === 'user') {
            $user = User::find($id)->with(['profile'])->first();
            $user->profile->avatar = $user->profile->avatar ? asset('dashboard/images/user_document/' . $user->email . '_' . $user->phone . '_' . $user->profile->uuid . '/' . $user->profile->avatar) : asset('dashboard/default/default_admin.jpg');
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            return $this->successResponse([
                'user' => $user,
            ]);
        } elseif ($type === 'driver') {
            $driver = Driver::find($id)->with(['profile' => function ($query) {
                $query->with(['profileMedia' => function ($mediaQuery) {
                    $mediaQuery->select('id', 'driver_profile_id', 'car_front_side', 'car_right_side', 'car_back_side', 'car_left_side', 'car_inside');
                }]);
            }])->first();
            $driver->profile->avatar = $driver->profile->avatar ? asset('dashboard/images/driver_document/' . $driver->email . $driver->phone . '_' . $driver->profile->uuid . '/' . $driver->profile->avatar) : asset('dashboard/default/default_admin.jpg');
            $driver->profile->profileMedia->map(function ($media) use ($driver) {
                $media->car_front_side = $media->car_front_side ? asset('dashboard/images/driver_document/' . $driver->email .  $driver->phone . '_' . $driver->profile->uuid . '/' . $media->car_front_side) : null;
                $media->car_back_side = $media->car_back_side ? asset('dashboard/images/driver_document/' . $driver->email .  $driver->phone . '_' . $driver->profile->uuid . '/' . $media->car_back_side) : null;
                $media->car_right_side = $media->car_right_side ? asset('dashboard/images/driver_document/' . $driver->email .  $driver->phone . '_' . $driver->profile->uuid . '/' . $media->car_right_side) : null;
                $media->car_left_side = $media->car_left_side ? asset('dashboard/images/driver_document/' . $driver->email .  $driver->phone . '_' . $driver->profile->uuid . '/' . $media->car_left_side) : null;
                $media->car_inside = $media->car_inside ? asset('dashboard/images/driver_document/' . $driver->email . $driver->phone . '_' . $driver->profile->uuid . '/' . $media->car_inside) : null;
                return $media;
            });
            if (!$driver) {
                return $this->errorResponse('Driver not found', 404);
            }
            return $this->successResponse([
                'driver' => $driver,
            ]);
        } else {
            return $this->errorResponse('Invalid type', 401);
        }
    }


}