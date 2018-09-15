<?php

namespace App\Models;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    public function getJwt() {
        $payload = [
            'iss' => 'lumen-jwt', // issuer of token
            'sub' => $this->id,
            'iat' => time(), // time JWT was issued
            'exp' => time() + 60*60, // expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public static function create(string $email, string $password) {
        $user = new self(['email' => $email]);
        $user->password = app('hash')->make($password);
        $user->save();

        return $user;
    }

    public static function authenticate(string $email, string $password) {
        $user = static::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        return $user;
    }
}
