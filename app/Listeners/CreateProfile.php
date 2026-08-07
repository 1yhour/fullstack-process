<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserRegistered;
use App\Facade\Notify;
class CreateProfile
{
    /**
     * Create the event listener.
     */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        Notify::createProfile($event->user);
        
        // Log::info("Profile created for " . $event->user->email);
        // $profile = User::create(
        //     [
        //         'user_id' => $event->user->id,
        //         'name' => $event->user->name,
        //     ]
        // );
    }
}
