<?php

namespace App\Services;

use App\Models\TvDbRefreshToken;
use GuzzleHttp\Client;

class TvDb {
    private static $API_BASE_URL = 'https://api.thetvdb.com';
    private static $EXPIRATION_DURATION = 60 * 60 * 23; // 23 hours

    private $client;
    // TODO: MAKE PRIVATE
    public $token;

    public function __construct() {
        $this->client = new Client();
        $this->setRefreshToken();
    }

    public function search(string $query) {
        $query = trim($query);
        if (strlen($query) === 0) return [];

        return $this->get('/search/series', [
            'name' => $query,
        ]);
    }

    private function setRefreshToken() {
        $refreshToken = TvDbRefreshToken::get();
        $exp = time() + self::$EXPIRATION_DURATION;

        if (!$refreshToken || $refreshToken->updated_at->getTimestamp() >= $exp) {
            $token = $this->login()['token'];
            $refreshToken = TvDbRefreshToken::set($token);
        }

        $this->token = $refreshToken->token;
    }

    private function get(string $uri, array $params = []) {
        return $this->call('GET', $uri, [
            'query' => $params,
            'headers' => [
                'authorization' => "Bearer {$this->token}",
            ],
        ]);
    }

    private function login() {
        return $this->call('POST', '/login', [
            'json' => ['apiKey' => env('TVDB_KEY')],
        ]);
    }

    private function call(string $method, string $uri, array $params = []) {
        $endpoint = self::$API_BASE_URL . $uri;

        return json_decode(
            $this->client->request(
                $method,
                $endpoint,
                $params
            )->getBody(),
            true
        );
    }
}

