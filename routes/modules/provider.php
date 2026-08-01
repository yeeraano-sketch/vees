<?php

use Illuminate\Support\Facades\Route;

use App\Provider\Presentation\Http\Controllers\RegisterProviderController;

Route::post(
    '/providers',
    RegisterProviderController::class,
);
