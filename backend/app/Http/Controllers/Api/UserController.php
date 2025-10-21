<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::query()->paginate(15);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreUserRequest $request) {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] =Hash::make($data['password']);
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($data);
        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(UpdateUserRequest $request, User $user) {
        $data = $request->validated();

        if (array_key_exists('password', $data) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('avatar')) {
            // (opțional) Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(User $user) {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->noContent(); // 204
    }
}
