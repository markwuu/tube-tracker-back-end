<?php

namespace App\Http\Controllers;

use App\Models\User;
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
             ? response()->json(['token' => $user->getJwt()], 200)
             : response()->json(['error' => 'Invalid email or password'], 401);
    }


    public function refreshToken(Request $request) {
        return response()->json([
            'token' => $request->auth->getJwt(),
        ], 200);
    }
}

