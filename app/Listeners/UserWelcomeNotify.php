<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Contracts\UserNotifier;
use App\Events\UserNotify;
class UserWelcomeNotify
{
    /**
     * Create the event listener.
     */
    public function __construct(public UserNotifier $userNoti)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserNotify $event): void
    {
        $this->userNoti->createProfile($event->user);
        $this->userNoti->sendWelcomeEmail($event->user);
        $this->userNoti->giveCouponToUser($event->user,$event->product);
    }
}
