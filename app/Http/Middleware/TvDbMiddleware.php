<?php

namespace App\Http\Middleware;

use App\Models\TvDbRefreshToken;
use Closure;
use GuzzleHttp\Client;

class TvDbMiddleware {
    private static $API_BASE_URL = 'https://api.thetvdb.com';
    private static $EXPIRATION_DURATION = 60 * 60 * 24; // 24 hours

    public function handle($request, Closure $next, $guard = null) {
        $refreshToken = TvDbRefreshToken::get();
        $exp = time() + self::$EXPIRATION_DURATION;

        if (!$refreshToken || $refreshToken->updated_at->getTimestamp() >= $exp) {
            $refreshToken = $this->refreshToken();
        }

        $request->tvDbToken = $refreshToken->token;
        return $next($request);
    }

    private function refreshToken() {
        $client = new Client();
        $response = json_decode($client->request('POST', self::$API_BASE_URL . '/login', [
            'json' => [
                'apiKey' => env('TVDB_KEY'),
            ],
        ])->getBody());

        return TvDbRefreshToken::set($response->token);
    }
}

