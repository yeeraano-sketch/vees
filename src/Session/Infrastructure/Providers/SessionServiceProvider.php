<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

final class SessionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        (new SessionRegistrar($this->app))->register();
    }
}
