<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\TokenResource;
use App\Models\DeviceToken;
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
        //  WARNING: Web guard ?
        $token = $request->string('data.attributes.deviceToken');
        if ($token->isNotEmpty()) {
            $deviceToken = Auth::user()->deviceTokens()->where('token', $token);

            if (! $deviceToken->exists()) {
                return $this->response->error(
                    title: 'Device token not found',
                    detail: 'The device token provided does not exist',
                    code: Response::HTTP_NOT_FOUND,
                )->build();
            }

            $deviceToken->delete();
        }

        Auth::guard('sanctum')->user()->currentAccessToken()->delete();

        return $this->response->message('Logged out successfully')->build(Response::HTTP_OK);
    }
}
