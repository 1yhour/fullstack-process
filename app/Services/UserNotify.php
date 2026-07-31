<?php
namespace App\Services;
use App\Models\User;
use App\Contracts\UserNotifier;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
class UserNotify implements UserNotifier{
    public function sendWelcomeEmail(User $user):void
    {
        Log::info('Welcome User: ' . $user->email);
    }
    public function createProfile(User $user): void
    {
        $data = [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
        Log::info('User Profile info created: '. json_encode($data));
    }
    public function giveCouponToUser(User $user, Product $product): void
    {
        Log::info($user->name . 'Give Coupon: ' . $product->name . ' Amount: ' . $product->price);
    }
}