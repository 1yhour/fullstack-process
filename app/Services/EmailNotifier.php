<?php
namespace App\Services;
use App\Contracts\Notifier;
use Illuminate\Support\Facades\Log;
use App\Contracts\SmsNotifier;
use App\Models\User;
class EmailNotifier implements Notifier{
    public function send(string $message):void
    {
        Log::info("Email from {$message}");
    }
    public function calculateSum(int $num1, int $num2): int
    {
        return $num1 + $num2;
    }
    public function filterNum(array $arr)
    {
        $number = array_filter($arr, function($item){
            return $item > 5;
        });
        Log::info($number);
        return $number;
    }

    public function sendWelcomeEmail(User $user): void
    {
        
        Log::info("Welcome email sent to " . $user->email);
    }
}