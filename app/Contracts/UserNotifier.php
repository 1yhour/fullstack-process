<?php
namespace App\Contracts;
use App\Models\User;
use App\Models\Product;
interface UserNotifier{
    public function sendWelcomeEmail(User $user): void;
    public function createProfile(User $user): void;
    public function giveCouponToUser(User $user, Product $product): void;
}