<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ProfileController;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use Illuminate\Support\Facades\Auth;

class DriverProfileController extends Controller implements ProfileController
{
    public function index()
    {
        return DriverResource::make(Auth::user()->driver);
    }
}

