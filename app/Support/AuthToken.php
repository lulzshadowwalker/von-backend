<?php

namespace App\Support;

class AuthToken
{
    public function __construct(protected string $token)
    {
        //
    }

    public function token(): string
    {
        return $this->token;
    }
}
