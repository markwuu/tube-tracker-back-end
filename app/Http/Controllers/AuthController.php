<?php

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;

class AuthController extends BaseController
{
    public function authenticate(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::authenticate($email, $password);

        return $user
             ? response()->json(['token' => $this->jwt($user)], 200)
             : response()->json(['error' => 'Invalid email or password'], 401);
    }

    protected function jwt(User $user) {
        $payload = [
            'iss' => 'lumen-jwt', // issuer of token
            'sub' => $user->id,
            'iat' => time(), // time JWT was issued
            'exp' => time() + 60*60, // expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }
}

