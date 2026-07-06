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
class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = DB::transaction(function() use ($data){
            return User::create($data);
        });
        $token = JWTAuth::fromUser($user);
        return response()->json([
            "success"=> true,
            "message"=> "Successfully register",
            "data"=> new UserResource($user),
            "token"=> $token
        ], 201);
    } 
}
