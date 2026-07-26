<?php
namespace App\Contracts;

use Illuminate\Support\Facades\Log;

interface Notifier{
    public function send(string $message): void;
}