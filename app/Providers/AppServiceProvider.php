<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Notifier;
use App\Services\EmailNotifier;
use App\Contracts\SmsNotifier;
use App\Services\SmsNotify;
use App\Services\UserNotify;
use App\Contracts\UserNotifier;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Notifier::class, EmailNotifier::class);
        $this->app->bind(SmsNotifier::class, SmsNotify::class);
        $this->app->bind(UserNotifier::class, UserNotify::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
