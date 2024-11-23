<?php

namespace App\Policies;

use App\Models\User;
use Bavix\Wallet\Models\Transaction;

class TransactionPolicy
{
    public function __construct()
    {
        //
    }

    public function view(User $user, Transaction $transaction)
    {
        return $transaction->wallet->holder->user->id === $user->id;
    }
}
