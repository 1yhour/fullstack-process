<?php
namespace App\Contracts;
use App\Models\User;
interface SmsNotifier{
    public function sendSms(User $user): void;
}