<?php

declare(strict_types=1);

namespace App\Framework\Modules;

use Illuminate\Contracts\Foundation\Application;

use App\Framework\Persistence\LaravelUnitOfWork;

use App\SharedKernel\Application\Contracts\UnitOfWork;
use App\SharedKernel\Application\Bus\TransactionalCommandBus;
use App\SharedKernel\Application\Dispatcher\EventDispatcher;
use App\SharedKernel\Application\EventBus\EventBus;
use App\SharedKernel\Application\EventBus\SynchronousEventBus;
use App\SharedKernel\Application\Subscribers\SubscriberRegistry;
use App\SharedKernel\Application\Transactions\AggregateCollector;

final readonly class ModulesRegistry
{
    public function __construct(
        private Application $app,
    ) {
    }

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
    }
}
