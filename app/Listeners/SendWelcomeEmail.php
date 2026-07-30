<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserRegistered;
use App\Contracts\Notifier;
class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected Notifier $notifier
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $this->notifier->sendWelcomeEmail($event->user);
    }
}
