<?php

declare(strict_types=1);

namespace Vees\Core\Framework\Providers;

use Illuminate\Support\ServiceProvider;
use Vees\Core\Framework\Dispatcher\HandlerResolver;
use Vees\Core\Framework\Modules\ModulesRegistry;
use Vees\Core\SharedKernel\Application\Bus\QueryBus;
use Vees\Core\SharedKernel\Application\Bus\SynchronousQueryBus;
use Vees\Core\SharedKernel\Application\EventBus\AsyncEventBus;
use Vees\Core\SharedKernel\Application\EventBus\EventBus;

final class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(EventBus::class, AsyncEventBus::class);

        $this->app->singleton(QueryBus::class, function ($app) {
            return new SynchronousQueryBus(
                $app->make(HandlerResolver::class),
            );
        });

        (new ModulesRegistry($this->app))
            ->register();
    }

    public function boot(): void
    {
    }
}
