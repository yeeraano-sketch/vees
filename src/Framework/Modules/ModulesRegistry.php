<?php

declare(strict_types=1);

namespace Vees\Core\Framework\Modules;

use Illuminate\Contracts\Foundation\Application;
use Vees\Core\Framework\Persistence\LaravelUnitOfWork;
use Vees\Core\SharedKernel\Application\Bus\TransactionalCommandBus;
use Vees\Core\SharedKernel\Application\Contracts\UnitOfWork;
use Vees\Core\SharedKernel\Application\Dispatcher\EventDispatcher;
use Vees\Core\SharedKernel\Application\EventBus\EventBus;
use Vees\Core\SharedKernel\Application\EventBus\SynchronousEventBus;
use Vees\Core\SharedKernel\Application\Subscribers\SubscriberRegistry;
use Vees\Core\SharedKernel\Application\Transactions\AggregateCollector;
use Vees\Core\SharedKernel\Contracts\Clock;
use Vees\Core\SharedKernel\Contracts\UuidGenerator;
use Vees\Core\SharedKernel\Infrastructure\Clock\SystemClock;
use Vees\Core\SharedKernel\Infrastructure\Uuid\RamseyUuidGenerator;

final readonly class ModulesRegistry
{
    public function __construct(
        private Application $app,
    ) {}

    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Shared Infrastructure
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            UnitOfWork::class,
            LaravelUnitOfWork::class,
        );

        $this->app->singleton(
            AggregateCollector::class,
        );

        $this->app->singleton(
            SubscriberRegistry::class,
        );

        $this->app->singleton(
            EventBus::class,
            SynchronousEventBus::class,
        );

        $this->app->singleton(
            EventDispatcher::class,
        );

        $this->app->singleton(
            TransactionalCommandBus::class,
        );

        $this->app->singleton(
            Clock::class,
            SystemClock::class,
        );

        $this->app->singleton(
            UuidGenerator::class,
            RamseyUuidGenerator::class,
        );
    }
}
