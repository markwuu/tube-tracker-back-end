<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TvDbRefreshToken extends Model
{
    public $incrementing = false;
    protected $primaryKey = null;
    protected $table = 'refresh_token';

    protected $fillable = [
        'token',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function get() {
        return static::first();
    }

    public static function set(string $refreshToken) {
        $currentToken = static::first();

        if ($currentToken) $currentToken->delete();

        return static::create(['token' => $refreshToken]);
    }

}

