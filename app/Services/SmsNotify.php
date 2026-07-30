<?php

namespace App\Services;

use App\Contracts\SmsNotifier;
use Illuminate\Support\Facades\Log;
use App\Models\User;
class SmsNotify implements SmsNotifier
{
    public function sendSms(User $user): void
    {
        Log::info("Sms from " . $user->id);
    }
}
