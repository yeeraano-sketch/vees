<?php

use Illuminate\Support\Facades\Route;
use Vees\Core\Matching\Presentation\Http\Controllers\MatchingController;

Route::post('/matchings/dispatch', [MatchingController::class, 'dispatch']);
