<?php

declare(strict_types=1);

namespace Vees\Core\Scheduler\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Vees\Core\Scheduler\Application\Services\SchedulerEngine;

final class SchedulerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SchedulerEngine::class, fn () => new SchedulerEngine);
    }

    public function boot(): void {}
}
