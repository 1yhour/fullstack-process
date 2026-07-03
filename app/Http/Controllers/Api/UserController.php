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
    public function create(StoreUserRequest $request)
    {
        try{
            $validate = $request->validated();
            $user = User::create([
                "name" => $validate["name"],
                "email" => $validate["email"],
                "password" => Hash::make($validate["password"])
            ]);
            return response()->json(
                [
                    "success" => true,
                    "message" => "Successful Create User"
                ],201
            );
        }catch(\Throwable $e){
            Log::error("Failed to Create User: " . $e->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error",
                ], 401
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json(
            [
                "success" => true,
                "message" => "Successful Get User",
                "data" => new UserResource($user)
            ], 200
        );
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $request->whenFilled("password", function($password) use (&$validated){
            $validated["password"] = Hash::make($password);
        });
        $user->update($validated);
        
        return response()->json(
            [
                "success" => true,
                "message" => "Successfully updated the user",
                "data" => new UserResource($user)
            ], 200
        );
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
