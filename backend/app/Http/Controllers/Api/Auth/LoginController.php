<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends Controller
{
     public function __invoke(Request $request)
    {
       
        $data = $request->validate([
            'login'    => ['required', 'string'], // email SAU username
            'password' => ['required', 'string'],
        ]);

        $login = $data['login'];

        // determină dacă e email sau username
        $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);

        // caută utilizatorul
        //    - dacă e email, caută pe email
        //    - altfel, pe username (case-insensitive recomandat)
        $userQuery = User::query();

        if ($isEmail) {
            $userQuery->where('email', $login);
        } else {
            //căutare case-insensitive la username
            $userQuery->whereRaw('LOWER(username) = ?', [mb_strtolower($login)]);
        }

        $user = $userQuery->first();

        //verificare parola
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], Response::HTTP_UNAUTHORIZED);
        }

        //token Sanctum
        $device = substr($request->userAgent() ?? 'api', 0, 255);
        $token  = $user->createToken($device)->plainTextToken;

        return response()->json([
            'data' => [
                'id'       => $user->id,
                'username' => $user->username,
                'email'    => $user->email,
            ],
            'token' => $token,
        ]);
    }
}
