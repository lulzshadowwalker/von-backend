<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role as EnumsRole;
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
use Spatie\Permission\Models\Role as SpatieRole;

// TODO: Restrict the creation of drivers to the admin panel

//  NOTE: This is only meant for passengers as drivers can only be created by the admin from the dashboard panel
class RegisteredUserController extends ApiController
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $request->validate([
                //  TODO: Refactor into a form request
                'data.attributes.name' => ['required', 'string', 'max:255'],
                'data.attributes.email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                'data.attributes.password' => ['required', 'confirmed:data.attributes.passwordConfirmation', Rules\Password::defaults()],
                'data.attributes.avatar' => ['nullable', 'string'],
            ]);

            if (User::where('email', $request->string('data.attributes.email'))->exists()) {
                return $this->response->error(
                    title: 'User already registerd with the given email',
                    detail: 'A user with the given email already exists',
                    code: Response::HTTP_CONFLICT,
                    indicator: 'USER_ALREADY_EXISTS'
                )->build();
            }

            $user = User::create([
                'name' => $request->string('data.attributes.name'),
                'email' => $request->string('data.attributes.email'),
                'password' => Hash::make($request->string('data.attributes.password')),
            ]);

            $user->passenger()->create();

            $user->assignRole(SpatieRole::findByName(EnumsRole::PASSENGER->value));

            if ($avatar = $request->string('data.attributes.avatar')) {
                $user->addMediaFromBase64($avatar)
                    ->toMediaCollection('avatar');
            }

            if ($deviceToken = $request->string('data.attributes.deviceToken')) {
                $user->deviceTokens()->create([
                    'token' => $deviceToken,
                ]);
            }

            event(new Registered($user));

            Auth::login($user);

            $token = $user->createToken(config('app.name'))->plainTextToken;

            return response()->json(
                TokenResource::make(new AuthToken($token))->jsonSerialize(),
                Response::HTTP_CREATED
            );
        });
    }
}
