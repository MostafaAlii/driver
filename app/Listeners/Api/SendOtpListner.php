<?php

namespace App\Listeners\Api;

use App\Events\Api\SendOtpEvent;
use App\Models\SettingOtp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOtpListner
{

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendOtpEvent $event): \Illuminate\Http\JsonResponse
    {
        // Send Otp Sms Code
        $checkPhone = SettingOtp::where('phone', $event->data['phone'])->first();
        if (!$checkPhone) {
            SettingOtp::create([
                'Usertype_type' => $event->data['user_type'],
                'Usertype_id' => $event->data['user_id'],
                'phone' => $event->data['phone'],
                'verified' => false,
                'otp' => '123',
            ]);
            return response()->json('OTP Sent Successfully', 200);
        } else {
            return response()->json('The Phone Is Registered Before', 400);
        }
    }

}
