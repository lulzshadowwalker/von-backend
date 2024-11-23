<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TransactionResource;
use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Models\Wallet;

class WalletTransactionController extends ApiController
{
    public function index(Wallet $wallet)
    {
        $this->authorize('view', $wallet);

        return TransactionResource::collection($wallet->transactions);
    }

    public function show(Wallet $wallet, Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return TransactionResource::make($transaction);
    }
}
