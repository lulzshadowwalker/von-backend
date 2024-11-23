<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class WalletResource extends BaseJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'wallets',
            'id' => (string) $this->id,
            'attributes' => [
                'balance' => (string) $this->balanceFloat,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'links' => (object) [
                'self' => route('api.wallets.show', ['wallet' => $this->id]),
            ],
            'relationships' => (object) [
                'transactions' => (object) [
                    'data' => $this->transactions->map(function ($transaction) {
                        return [
                            'type' => 'transactions',
                            'id' => (string) $transaction->id,
                        ];
                    }),
                ],
            ],
            'includes' => (object) [
                'transactions' => $this->mergeWhen(
                    $this->include('transactions'),
                    TransactionResource::collection($this->whenLoaded('transactions'))
                ),
            ],
            'meta' => (object) [],
        ];
    }
}
