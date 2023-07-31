<?php
namespace App\Http\Controllers\Api\Auth\Base;
abstract class AbstractPasswordResetTokenHandler {
    abstract public function createToken(array $data);
    abstract public function findToken($token);
    abstract public function deleteToken($token);
    abstract public function createTokenByPhone($phone);  
}