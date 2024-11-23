<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TransactionResource;
use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Models\Wallet;

class WalletTransactionController extends ApiController
{
    public function index(Wallet $wallet)
    {
        //  TODO: Authorization

        return TransactionResource::collection($wallet->transactions);
    }

    public function show(Wallet $wallet, Transaction $transaction)
    {
        return TransactionResource::make($transaction);
    }
}
