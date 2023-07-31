<?php
namespace App\Http\Controllers\Api\Auth;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Events\Api\SendOtpEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{DB};
use Illuminate\Support\Facades\Validator;

class DriverAuthController extends Controller {
    public function __construct() {
        $this->middleware('auth:driver-api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:drivers,phone',
            'password' => 'required|string|min:5',
        ]);
        if ($validator->fails()) {
            $checkEmail = Driver::where('phone', $request->phone)->first();
            if (!$checkEmail) {
                return response()->json(['error' => 'Invalid Phone Or Password'], 401);
            }
        }
        $checkEmail = Driver::where('phone', $request->phone)->first();
        if ($checkEmail->status == "inactive") 
            return response()->json(['error' => sprintf('Your Account of %s is Deactivated', $checkEmail->name)], 401);
        
        if (!empty($checkEmail->email_verified_at)) {
            if (!$token = auth('driver-api')->attempt($request->only('phone','password'))) {
                return response()->json(['error' => 'Invalid Phone Or Password'], 401);
            }
            DB::table('drivers')->where('phone',$request->phone)->update(['online' => 1]);
            return $this->createNewToken($token);
        } else {
            return response()->json(['error' => 'The Driver Is not verified Accounts'], 401);
        }
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:drivers,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|numeric|unique:drivers,phone',
            'country_id' => 'required|numeric|exists:countries,id',
            'gender' => 'required|in:male,female',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 401);
        }
        try {
            $driver = Driver::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)]
            ));
            $data = [
                'user_type' => 'driver',
                'user_id' => $driver->id,
                'phone' => $driver->phone,
                'country_id' => $driver->country->name,
                'gender' => $driver->gender
            ];
            event(new SendOtpEvent($data));
            return response()->json([
                'message' => 'Drivers successfully registered',
                'driver' => $driver
            ], 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 401);
        }

    }

    public function logout() {
        $user = auth('driver-api')->user();
        auth('driver-api')->logout();
        $onlineStatus = $user->online ? 0 : 1;
        DB::table('drivers')->whereId($user->id)->update(['online' => $onlineStatus]);
        return response()->json(['message' => 'Driver successfully signed out']);
    }

    public function refresh() {
        return $this->createNewToken(auth('driver-api')->refresh());
    }

    public function driverProfile() {
        return response()->json(auth('driver-api')->user()->profile);
    }

    protected function createNewToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('driver-api')->factory()->getTTL() * 60,
            'driver' => auth('driver-api')->user(),
            'profile' => $this->driverProfile()
        ]);
    }
}
