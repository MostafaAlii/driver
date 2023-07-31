<?php

namespace App\Listeners\Api;

use App\Events\Api\CheckCodeVerifiedEvent;
use App\Models\Driver;
use App\Models\SettingOtp;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckCodeVerifiedListner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CheckCodeVerifiedEvent $event): \Illuminate\Http\JsonResponse
    {
        // Check Code On Api ;

        $code = 123;

        $checkType = SettingOtp::where('Usertype_type', $event->data['user_type'])
            ->where('Usertype_id', $event->data['user_id'])
            ->where('phone', $event->data['phone'])
            ->first();

        if ($checkType) {
            if ($checkType->verified == 0) {
                if ($code == $event->data['otp']) {
                    $checkType->update(['verified' => 1]);

                    if ($event->data['user_type'] == 'driver') {
                        Driver::findOrFail($event->data['user_id'])->update([
                            'email_verified_at' => now()
                        ]);
                    } else {
                        User::findOrFail($event->data['user_id'])->update([
                            'email_verified_at' => now()
                        ]);
                    }

                    return response()->json('OTP Checked Successfully', 200);
                } else {
                    return response()->json('The Code for ' . $event->data['user_type'] . ' is Incorrect', 400);
                }
            } else {
                return response()->json('The ' . $event->data['user_type'] . ' is already verified', 400);
            }
        } else {
            return response()->json('The ' . $event->data['user_type'] . ' does not exist', 400);
        }
    }
}
