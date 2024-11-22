<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\TokenResource;
use App\Support\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends ApiController
{
    /**
     * Login
     *
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $token = Auth::user()->createToken('authToken')->plainTextToken;

        return TokenResource::make(new AuthToken($token));
    }

    /**
     * Logout
     *
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->response->message('Logged out successfully')->build(Response::HTTP_OK);
    }
}
