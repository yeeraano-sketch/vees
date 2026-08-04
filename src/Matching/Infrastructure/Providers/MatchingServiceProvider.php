<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

final class MatchingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        (new MatchingRegistrar($this->app))->register();
    }
}
