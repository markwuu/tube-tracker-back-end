<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validate;

class ShowController extends Controller {
    public function index(Request $request) {
        $this->validate($request, [
            'query' => 'required|min:1',
        ]);

        return $request->tvDb->search($request->input('query'));
    }

    public function show(int $id, Request $request) {
        return $request->tvDb->find($id);
    }

    public function showEpisodes(int $id, Request $request) {
        return $request->tvDb->findEpisodes($id);
    }
}

