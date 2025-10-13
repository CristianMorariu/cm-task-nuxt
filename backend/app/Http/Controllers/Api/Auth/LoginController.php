<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends Controller
{
     public function __invoke(Request $request)
    {

        if (Auth::check()) {
        return response()->json(['already' => true], 200);
    }
    
        $data = $request->validate([
            'login'    => ['required','string'], // email SAU username
            'password' => ['required','string'],
            'remember' =>['boolean']
        ]);

        $login = $data['login'];
        $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);

        $credentials = [
            $isEmail ? 'email' : 'username' => $login,
            'password' => $data['password'],
        ];

        $remember = $data['remember'] ?? false;
        if (! Auth::attempt($credentials, $remember)) {
            return response()->json(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        // setează cookie de sesiune + protecție fixation
        $request->session()->regenerate();

        $user = Auth::user();

        return response()->json([
        'id' => Auth::id(),
        'username' => Auth::user()->username,
        'email' => Auth::user()->email,
        ]);
    }
}
