<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Traits\Api\ApiResponseTrait;
use Illuminate\Support\Facades\Validator;
use App\Events\Api\CheckCodeVerifiedEvent;
use App\Http\Resources\Users\UserResources;

class UserController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        try {
            return $this->successResponse(User::paginate(50), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }

    public function show_profile_user(Request $request)
    {
        try {
            return $this->successResponse(new UserResources(User::findorfail(auth('user-api')->user()->id)), 'data Return Successfully');
        } catch (\Exception $exception) {
            $this->errorResponse('Something went wrong, please try again later');
        }
    }


    public function verified(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $id = User::where('phone', $request->phone)->first();
        if (!$id){
            return response()->json(['error' => 'The User Is not Find'], 401);
        }
        $checkUserIsNotVerified = User::findorfail($id->id);
        if (!empty($checkUserIsNotVerified->email_verified_at)) {
            return $this->successResponse('The User is already verified');
        } else {
            // Check Sms Code

            $data = [
                'user_type' => 'user',
                'user_id' =>  $id->id,
                'phone' =>  $request->phone,
                'otp' => $request->otp,
            ];

            event(new CheckCodeVerifiedEvent($data));
        }
    }

    public function sendOtp(Request $request) {
        try {
            $phone = $request->input('phone');
            $otp = User::USER_OTP;
            $user = User::wherePhone($phone)->first();
            if (!$user) {
                return response()->json([
                    'error' => 'The User Is not Find'
                ], 401);
            } 
            DB::table('password_reset_tokens')->updateOrInsert(
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
            $user = User::wherePhone($request->phone)->first();
            if (!$user) 
                return $this->errorResponse('The User Is not Find');
            $token = DB::table('password_reset_tokens')->wherePhone($request->phone)->first();
            /*if (!$token) 
                return $this->errorResponse('The Otp Code Is not Find');
            if ($token->otp != $token->otp) 
                return $this->errorResponse('The Otp Code Is not Correct');*/
            $user->update(['password' => bcrypt($request->newPassword)]);
            DB::table('password_reset_tokens')->wherePhone($request->phone)->delete();
            return $this->successResponse('The Password has been reset successfully for ' . $user->name);
        } catch (\Exception $exception) {
            return $this->errorResponse('Something went wrong, please try again later');
        }
    }
}
