<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'login'    => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $login = trim($data['login']);

    // detectăm email vs username
    $query = User::query();
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $query->whereRaw('LOWER(email) = ?', [mb_strtolower($login)]);
    } else {
        $query->whereRaw('LOWER(username) = ?', [mb_strtolower($login)]);
    }

    $user = $query->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 422);
    }

    $token = $user->createToken('bruno')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => [
            'id'       => $user->id,
            'username' => $user->username,
            'email'    => $user->email,
            'role'     => is_object($user->role) ? $user->role->value : $user->role,
        ],
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('users', UserController::class);
});
// Route::middleware('auth:sanctum')->group(function () {
// });

