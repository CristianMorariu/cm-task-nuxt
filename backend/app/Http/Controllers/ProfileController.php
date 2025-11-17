<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMyPasswordRequest;
use App\Http\Requests\UpdateMyProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{

    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(UpdateMyProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        // upload avatar (opțional: șterge-l pe cel vechi)
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // nu forțăm parola aici
        unset($data['password']);

        $user->update($data);

        return new UserResource($user->fresh());
    }

    public function updatePassword(UpdateMyPasswordRequest $request)
    {
        $user = $request->user();

        // verifică parola curentă
        if (! Hash::check($request->validated()['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        $user->forceFill([
            'password' => Hash::make($request->validated()['password']),
        ])->save();

        return response()->noContent(); // 204
    }
}
