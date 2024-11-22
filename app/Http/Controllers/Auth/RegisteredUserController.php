<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TokenResource;
use App\Models\User;
use App\Support\AuthToken;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

// TODO: Restrict the creation of drivers to the admin panel

//  NOTE: This is only meant for passengers as drivers can only be created by the admin from the dashboard panel
class RegisteredUserController extends ApiController
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            if (User::where('email', $request->email)->exists()) {
                return $this->response->error(
                    title: 'User already registerd with the given email',
                    detail: 'A user with the given email already exists',
                    code: Response::HTTP_CONFLICT,
                    indicator: 'USER_ALREADY_EXISTS'
                )->build();
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->string('password')),
            ]);

            $user->passenger()->create();

            if ($deviceToken = $request->deviceToken) {
                $user->deviceTokens()->create([
                    'token' => $deviceToken,
                ]);
            }

            event(new Registered($user));

            Auth::login($user);

            $token = $user->createToken(config('app.name'))->plainTextToken;

            return TokenResource::make(new AuthToken($token));
        });
    }
}
