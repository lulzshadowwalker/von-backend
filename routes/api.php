<?php

use App\Contracts\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';


Route::get('/me', [ProfileController::class, 'index'])->middleware('auth:sanctum')->name('profile.index');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
