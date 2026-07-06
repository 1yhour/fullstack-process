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
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(15);
        return response()->json(
            [
                "success" => true,
                "message" => "Successfully fetched users",
                "data" => UserResource::collection($users)
            ], 200
        );
    }

    public function store(StoreUserRequest $request)
    {
        try{
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            $user = DB::transaction(function() use ($validated){
                return User::create($validated);
            });
            return response()->json(
                [
                    "success" => true,
                    "message" => "Successfully create user",
                    "data" => new UserResource($user)
                ], 201
            );
        }catch(\Throwable $e){
            Log::error("Failed to create the user" . $e->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Internal server error",
                ], 500
            );
        }
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
