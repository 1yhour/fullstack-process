<?php
namespace App\Services;
use App\Contracts\Notifier;
use Illuminate\Support\Facades\Log;
class EmailNotifier implements Notifier{
    public function send(string $message):void
    {
        Log::info("Email from {$message}");
    }
}