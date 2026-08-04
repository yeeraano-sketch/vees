<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Vees\Core\Session\Presentation\Http\Controllers\SessionController;

Route::post('/sessions', [SessionController::class, 'store']);
Route::post('/sessions/{sessionId}/accept', [SessionController::class, 'accept']);
Route::post('/sessions/{sessionId}/complete', [SessionController::class, 'complete']);
Route::post('/sessions/{sessionId}/cancel', [SessionController::class, 'cancel']);
