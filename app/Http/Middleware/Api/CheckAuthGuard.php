<?php
namespace App\Http\Middleware\Api;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\Api\Implementations;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Services\Api\Contracts\AuthStrategy;

use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Http\Traits\Api\GeneralApiTrait;
use \Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CheckAuthGuard extends BaseMiddleware {
    use GeneralApiTrait;
    public function handle($request, Closure $next, $guard = null) {
        if($guard != null) {
            auth()->shouldUse($guard);
            $token = $request->header('auth_token');
            dd($token);
            $request->headers->set('auth_token', $token, true);
            $request->headers->set('Authorization', 'Bearer ' . $token, true);
            try {
                $user = JWTAuth::parseToken()->authenticate(); // User Authenticated Checked
            } catch (TokenExpiredException $ex) {
                return $this->returnErrorMessage('401',__('unauthenticated_user'));
            } catch (JWTException $ex) {
                return $this->returnErrorMessage('',__('invalid_token'), $ex->getMessage());
            }
        }
        return $next($request);
    }
}