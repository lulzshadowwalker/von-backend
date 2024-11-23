<?php

use App\Contracts\ProfileController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\WalletTransactionController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('/wallets/{wallet}', [WalletController::class, 'show'])->name('wallets.show');
    Route::patch('/wallets/{wallet}', [WalletController::class, 'update'])->name('wallets.update');

    Route::get('/wallets/{wallet}/transactions', [WalletTransactionController::class, 'index'])->name('wallets.transactions.index');
    Route::get('/wallets/{wallet}/transactions/{transaction}', [WalletTransactionController::class, 'show'])->name('wallets.transactions.show');
});
