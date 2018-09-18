<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function showShows(Request $request) {
        $showIds = $request->auth->getShows();

        $shows = array_map(function(int $showId) use ($request) {
            return $request->tvDb->find($showId);
        }, $showIds);

        return response()->json($shows);
    }

    public function addShow(Request $request) {
        $user_id = $request->auth->id;
        $this->validate($request, [
            'show_id' => "required|unique:users_shows,show_id,NULL,id,user_id,{$user_id}",
        ]);

        $showId = $request->input('show_id');

        if (!$request->tvDb->isValidShow($showId)) {
            return response()->json(['show_id' => ['Invalid show id']]);
        }

        return $request->auth->addShow($showId);
    }
}
