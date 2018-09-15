<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller {
    public function create(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::create($email, $password);

        return response()->json(['token' => $user->getJwt()]);
    }

    public function me(Request $request) {
        return response()->json($request->auth);
    }
}
