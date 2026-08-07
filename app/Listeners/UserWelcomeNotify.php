<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Contracts\UserNotifier;
use App\Events\UserNotify;
use App\Facades\Notify;
class UserWelcomeNotify
{
    /**
     * Create the event listener.
     */
    // public function __construct(public UserNotifier $userNoti)
    // {
    //     // it will get the instance of UserNotifier from the Service Container
    // }   

    /**
     * Handle the event.
     */
    public function handle(UserNotify $event): void
    {
        // $this->userNoti->createProfile($event->user);
        // $this->userNoti->sendWelcomeEmail($event->user);
        // $this->userNoti->giveCouponToUser($event->user,$event->product);
        Notify::createProfile($event->user);
        Notify::sendWelcomeEmail($event->user);
        Notify::giveCouponToUser($event->user,$event->product);
    }
}
