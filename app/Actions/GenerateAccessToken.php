<?php

namespace App\Actions;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * Generate a new access token for the given user.
 */
class GenerateAccessToken
{
    /**
     * Generate a new access token for the given user.
     *
     * @param  \Illuminate\Foundation\Auth\User  $user
     * @param  string|null  $deviceName
     * @return string
     */
    public function generate(
        Authenticatable $user,
        string $deviceName = null
    ) {
        return $user->createToken($deviceName ?? config('app.name'))->plainTextToken;
    }
}
