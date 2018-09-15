<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowController extends Controller {
    public function index(Request $request) {
        return $request->tvDbToken;
    }
}

