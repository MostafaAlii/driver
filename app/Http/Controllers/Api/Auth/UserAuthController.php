<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\Api\SendOtpEvent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

//use Validator;

class UserAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user-api', ['except' => ['login', 'register', 'sendOtp', 'resetPassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:users,phone',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            $checkEmail = User::where('phone', $request->phone)->first();
            if (!$checkEmail) {
                return response()->json(['error' => 'Invalid Phone Or Password'], 401);
            }
        }

       $checkEmail = User::where('phone', $request->phone)->first();
        if ($checkEmail->status == "inactive") 
            return response()->json(['error' => sprintf('Your Account of %s is Deactivated', $checkEmail->name)], 401);

        if (!empty($checkEmail->email_verified_at)) {
            if (!$token = auth('user-api')->attempt($validator->validated())) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $this->createNewToken($token);
        } else {
            return response()->json(['error' => 'The User Is not verified Accounts'], 401);
        }


    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|numeric|unique:users,phone',
            'country_id' => 'required|numeric|exists:countries,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)]
            ));

            $data = [
                'user_type' => 'user',
                'user_id' => $user->id,
                'phone' => $user->phone,
                'country_id' => $user->country->name
            ];
            event(new SendOtpEvent($data));
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $user
            ], 201);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 400);
        }

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('user-api')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth('user-api')->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth('user-api')->user()->profile);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('user-api')->factory()->getTTL() * 60,
            'user' => auth('user-api')->user(),
            'profile' => $this->userProfile()
        ]);
    }
}
