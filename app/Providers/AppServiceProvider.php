<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Notifier;
use App\Services\EmailNotifier;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Notifier::class, EmailNotifier::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
