<?php

declare(strict_types=1);

namespace Vees\Core\Recovery\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Vees\Core\Recovery\Application\Services\RecoveryEngine;

final class RecoveryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RecoveryEngine::class, function ($app) {
            return new RecoveryEngine(
                $app->make(\Vees\Core\Session\Domain\Contracts\SessionRepository::class),
                $app->make(\Vees\Core\SharedKernel\Application\EventBus\EventBus::class),
            );
        });
    }

    public function boot(): void
    {
    }
}
