<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

final class IdentityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        (new IdentityRegistrar($this->app))->register();
    }
}
