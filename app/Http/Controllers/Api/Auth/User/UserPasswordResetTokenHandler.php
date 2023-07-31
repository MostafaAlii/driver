<?php
namespace App\Http\Controllers\Api\Auth\User;
use App\Http\Controllers\Api\Auth\Base\AbstractPasswordResetTokenHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class UserPasswordResetTokenHandler extends AbstractPasswordResetTokenHandler {
    public function createTokenByPhone($phone) {
        $token = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'phone' => $phone,
            'token' => $token,
            'created_at' => now(),
        ]);
        return $token;
    }

    public function createToken(array $data) {
        $token = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'phone' => $data['phone'],
            'token' => $token,
            'created_at' => now(),
        ]);
        return $token;
    }

    public function findToken($token) {
        return DB::table('password_reset_tokens')->where('token', $token)->first();
    }

    public function deleteToken($token) {
        DB::table('password_reset_tokens')->where('token', $token)->delete();
    }
}