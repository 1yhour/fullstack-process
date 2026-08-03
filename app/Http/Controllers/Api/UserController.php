<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Traits\ApiResponseTrait;
class UserController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        Gate::authorize('viewAny', User::class);
        $users = User::latest()->paginate(15);
        return $this->successResponse("Successfully fetched users", UserResource::collection($users));
    }

    public function store(StoreUserRequest $request)
    {
        Gate::authorize('create', User::class);
        try{
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            $user = DB::transaction(function() use ($validated){
                $user = User::create($validated);
                UserRegistered::dispatch($user);
                Log::info("User created successfully: " . $user->email);
                return $user;
            });
            return $this->successResponse("Successfully create user", new UserResource($user), null, 201);
        }catch(\Throwable $e){
            Log::error("Failed to create the user" . $e->getMessage());
            return $this->errorResponse("Internal server error", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);
        return $this->successResponse("Successful Get User", new UserResource($user));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        Gate::authorize('update',$user);
        $validated = $request->validated();
        $request->whenFilled("password", function($password) use (&$validated){
            $validated["password"] = Hash::make($password);
        });
        $user->update($validated);
        
        return $this->successResponse("Successfully updated the user", new UserResource($user));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        $user->delete();
        return $this->successMessage("Successfully deleted");
    }
}
