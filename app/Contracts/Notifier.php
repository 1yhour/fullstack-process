<?php
namespace App\Contracts;
use App\Models\User;
interface Notifier{
    public function send(string $message): void;
    public function calculateSum(int $num1, int $num2): int;
    public function filterNum(array $arr);
    public function sendWelcomeEmail(User $user): void;

}