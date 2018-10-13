<?php

namespace App\Services;

use App\Models\TvDbRefreshToken;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TvDb {
    private static $API_BASE_URL = 'https://api.thetvdb.com';

    private $client;
    private $token;

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

    public function find(int $id) {
        return $this->get("/series/${id}");
    }

    public function findEpisodes(int $id) {
        return $this->get("/series/${id}/episodes");
    }

    public function isValidShow(int $id) {
        try {
            $this->find($id);
            return true;
        } catch (RequestException $e) {
            return false;
        }
    }

    private function setRefreshToken() {
        $refreshToken = TvDbRefreshToken::get();

        if (!$refreshToken || $refreshToken->isExpired()) {
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
            'json' => [
                'apikey' => env('TVDB_KEY'),
                'userkey' => env('TVDB_USERKEY'),
                'username' => env('TVDB_USERNAME'),
            ],
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

