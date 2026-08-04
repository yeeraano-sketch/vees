<?php

use Illuminate\Support\Facades\Route;
use Vees\Core\Provider\Presentation\Http\Controllers\ProviderController;

Route::post('/providers', [ProviderController::class, 'store']);
