<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TransactionResource extends BaseJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => 'transactions',
            'id' => (string) $this->id,
            'attributes' => [
                'uuid' => $this->uuid,
                'amount' => (string) $this->amountFloat,
                'type' => $this->type,
                'isConfirmed' => $this->confirmed,
                'title' => $this->meta['title'] ?? null,
                'description' => $this->meta['description'] ?? null,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'links' => (object) [
                'self' => route('api.wallets.transactions.show', [
                    'wallet' => $this->wallet_id,
                    'transaction' => $this->id,
                ]),
            ],
            'links' => (object) [],
            'relationships' => (object) [
                'wallet' => (object) [
                    'data' => [
                        'type' => 'wallets',
                        'id' => (string) $this->wallet_id,
                    ],
                ],
            ],
            'includes' => (object) [
                'wallet' => $this->mergeWhen(
                    $this->include('wallet'),
                    WalletResource::make($this->whenLoaded('wallet'))
                ),
            ],
            'meta' => (object) [],
        ];
    }
}
