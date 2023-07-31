<?php
namespace App\Http\Controllers\Api\Auth\User;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\Api\SendOtpEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\Auth\User\UserPasswordResetTokenHandler;

class UserPasswordResetController extends Controller {
    public function __construct(private UserPasswordResetTokenHandler $passwordResetTokenHandler) {
        $this->passwordResetTokenHandler = $passwordResetTokenHandler;
    }

    public function createToken() {
        $data = request()->validate([
            'phone' => 'required|regex:/^09\d{9}$/',
        ]);
        $token = $this->passwordResetTokenHandler->createToken($data);

        event(new SendOtpEvent($data));
            return response()->json([
                'message' => 'Users successfully created',
                'token' => $token
        ], 201);
    }

    public function sendResetToken(Request $request) {
        $phone = $request->input('phone');
        $token = $this->passwordResetTokenHandler->createTokenByPhone($phone);
        return response()->json([
            'message' => 'User successfully created',
            'token' => $token
        ], 201);
    }

    public function resetPassword(Request $request) {
        $token = $request->input('reset_token');
        $newPassword = $request->input('new_password');
        $tokenData = $this->passwordResetTokenHandler->findToken($token);
        if (!$tokenData) {
            return response()->json(['message' => 'رمز إعادة تعيين كلمة المرور غير صالح'], 400);
        }
        $user = User::where('phone', $tokenData->phone)->first();
        if (!$user) {
            return response()->json(['message' => 'حدث خطأ غير متوقع'], 500);
        }
        $user->update(['password' => Hash::make($newPassword)]);
        $this->passwordResetTokenHandler->deleteToken($token);
        return response()->json(['message' => 'تم إعادة تعيين كلمة المرور بنجاح ' .  $user?->name ], 200);
    }
}