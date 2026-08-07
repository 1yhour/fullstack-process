<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Contracts\SmsNotifier;
use App\Events\UserRegistered;
use App\Facade\Notify;
class SendWelcomeSms
{
    /**
     * Create the event listener.
     */
    // public function __construct(public SmsNotifier $sms)
    // {
    //     //
    // }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        Notify::sendSms($event->user);
    }
}
