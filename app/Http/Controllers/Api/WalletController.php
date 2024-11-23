<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WalletResource;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends ApiController
{
    public function show(Wallet $wallet)
    {
        $this->authorize('view', $wallet);

        return WalletResource::make($wallet);
    }

    public function update(Request $request, Wallet $wallet)
    {
        //  TODO: Implement WalletController.update()
    }
}
