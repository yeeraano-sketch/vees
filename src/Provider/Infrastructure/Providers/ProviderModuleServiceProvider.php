<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

final class ProviderModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        (new ProviderRegistrar($this->app))->register();
    }
}
