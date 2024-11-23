<?php

namespace App\Providers;

use App\Contracts\ProfileController;
use App\Contracts\ResponseBuilder;
use App\Http\Controllers\Api\DriverProfileController;
use App\Http\Controllers\Api\PassengerProfileController;
use App\Http\Response\JsonResponseBuilder;
use Exception;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ResponseBuilder::class, JsonResponseBuilder::class);

        //  NOTE: ProfileController
        $this->app->bind(ProfileController::class, function ($app) {
            if (Auth::user()->isPassenger) {
                return $app->make(PassengerProfileController::class);
            } else if (Auth::user()->isDriver) {
                return $app->make(DriverProfileController::class);
            }

            throw new Exception('User role is not recognized: ' . Auth::user()->role);
        });
    }

    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
