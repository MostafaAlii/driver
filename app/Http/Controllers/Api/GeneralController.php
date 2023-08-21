<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\{User, Driver};
use App\Http\Controllers\Controller;
use App\Http\Traits\Api\ApiResponseTrait;

class GeneralController extends Controller {
    use ApiResponseTrait;
    public function checkPhoneExists(Request $request) {
        try {
            $this->validate($request, [
                'phone' => 'required|string',
                'type' => 'required|in:driver,user',
            ]);
            $phone = $request->input('phone');
            $type = $request->input('type');
            $phoneExists = false;
            $name = '';
            if ($type === 'driver') {
                $phoneExists = Driver::wherePhone($phone)->exists();
                if ($phoneExists) {
                    $driver = Driver::wherePhone($phone)->first();
                    $name = $driver->name;
                }
            } elseif ($type === 'user') {
                $phoneExists = User::wherePhone($phone)->exists();
                if ($phoneExists) {
                    $user = User::wherePhone($phone)->first();
                    $name = $user->name;
                }
            }
            $message = $phoneExists ? "Phone number exists for $name." : 'Phone number does not exist.';
            return $this->successResponse([
                    'message' => $message,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Invalid ' . ($type ?? 'type') . ' value');
        }
    }
}
