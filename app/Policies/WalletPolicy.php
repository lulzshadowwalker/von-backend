<?php

namespace App\Policies;

use App\Models\User;
use Bavix\Wallet\Interfaces\Wallet;

class WalletPolicy
{
    public function __construct()
    {
        //
    }

    public function view(User $user, Wallet $wallet)
    {
        return $wallet->holder->user->id === $user->id;
    }
}
