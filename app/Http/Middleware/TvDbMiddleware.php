<?php

namespace App\Http\Middleware;

use App\Models\TvDbRefreshToken;
use App\Services\TvDb;
use Closure;

class TvDbMiddleware {
    public function handle($request, Closure $next, $guard = null) {
        $request->tvDb = new TvDb();
        return $next($request);
    }

}

