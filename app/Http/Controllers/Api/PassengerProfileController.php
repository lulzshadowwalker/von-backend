<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ProfileController;
use App\Http\Controllers\Controller;
use App\Http\Resources\PassengerResource;
use Illuminate\Support\Facades\Auth;

class PassengerProfileController extends Controller implements ProfileController
{
    public function index()
    {
        // TODO: Authorization ?
        return PassengerResource::make(Auth::user()->passenger);
    }
}
