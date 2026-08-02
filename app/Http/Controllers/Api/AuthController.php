<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Http\Requests\LoginRequest;
use App\Events\UserNotify;
use App\Models\Product;
use App\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = DB::transaction(function() use ($data){
            return User::create($data);
        });
        $welcomeCoupon = Product::where('name', 'Welcome Coupon')->first();
        UserNotify::dispatch($user, $welcomeCoupon);
        $token = JWTAuth::fromUser($user);
        return $this->successResponse("Successfully register", new UserResource($user), $token, 201);
    } 
    
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $guard = auth('api');
        if(!$token = $guard->attempt($credentials)){
            return $this->errorResponse("Invalid email or password");
        }
        $data = [
            "user"=>new UserResource($guard->user()),
            "access_token" => $token,
            "token_type" => "Bearer",
        ];
        return $this->successResponse("Successfully login", $data);
    }

    public function logout(){
        auth()->logout();
        return $this->successMessage("Successfully logout");
    }

    public function me(){
        $user = auth()->user();
        return $this->successResponse("Successfully get user", new UserResource($user), 200);
    }

    public function refresh(){
        $newToken = auth()->refresh();
        return $this->successMessage("Token refreshed successfully", 200, $newToken);
    }
}
