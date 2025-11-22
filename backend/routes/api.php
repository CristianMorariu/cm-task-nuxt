<?php

use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

// Route::post('/login', function (Request $request) {
//     $data = $request->validate([
//         'login'    => ['required', 'string'],
//         'password' => ['required', 'string'],
//     ]);

//     $login = trim($data['login']);

//     // detectăm email vs username
//     $query = User::query();
//     if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
//         $query->whereRaw('LOWER(email) = ?', [mb_strtolower($login)]);
//     } else {
//         $query->whereRaw('LOWER(username) = ?', [mb_strtolower($login)]);
//     }

//     $user = $query->first();

//     if (!$user || !Hash::check($data['password'], $user->password)) {
//         return response()->json(['message' => 'Invalid credentials'], 422);
//     }

//     $token = $user->createToken('bruno')->plainTextToken;

//     return response()->json([
//         'token' => $token,
//         'user'  => [
//             'id'       => $user->id,
//             'username' => $user->username,
//             'email'    => $user->email,
//             'role'     => is_object($user->role) ? $user->role->value : $user->role,
//         ],
//     ]);
// });

Route::get('/meta/roles', function () {
    // cache optional, 1 oră
    return Cache::remember('meta.roles', 3600, function () {
        $data = array_map(
            fn(UserRole $r) => ['key' => $r->value, 'label' => $r->label()],
            UserRole::cases()
        );
        return response()->json(['data' => $data]);
    });
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('users', UserController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [ProfileController::class, 'show']);
    Route::patch('/me', [ProfileController::class, 'update']);
    Route::patch('/me/password', [ProfileController::class, 'updatePassword']);
});
