<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Vees\Core\Payment\Presentation\Http\Controllers\PaymentController;

Route::post('/payments', [PaymentController::class, 'store']);
