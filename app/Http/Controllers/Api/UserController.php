<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return UserResource::collection($user);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used in API resource routes
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try{
            $validate = $request->validated();
            
            // It's best to use User::create() statically here
            $user = User::create([
                "name" => $validate["name"],
                "email" => $validate["email"],
                "password" => Hash::make($validate["password"])
            ]);
            
            return response()->json(
                [
                    "success" => true,
                    "message" => "Successful Create User",
                    "data" => new UserResource($user)
                ],201
            );
        }catch(\Throwable $e){
            // Fixed typo 'erorr' to 'error', and 'message()' to 'getMessage()'
            Log::error("Failed to Create User: " . $e->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error",
                ], 500 // 500 is the correct code for server errors
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(
            [
                "success" => true,
                "message" => "Successfully deleted",
            ], 200
        );
    }
}
