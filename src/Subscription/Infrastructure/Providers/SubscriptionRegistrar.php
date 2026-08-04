<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Infrastructure\Providers;

use Illuminate\Contracts\Foundation\Application;
use Vees\Core\Subscription\Domain\Aggregates\Subscription\SubscriptionFactory;
use Vees\Core\Subscription\Domain\Contracts\SubscriptionRepository;
use Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Assemblers\SubscriptionPersistenceAssembler;
use Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Mappers\SubscriptionMapper;
use Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Repositories\EloquentSubscriptionRepository;

final readonly class SubscriptionRegistrar
{
    public function __construct(
        private Application $app,
    ) {}

    public function register(): void
    {
        $this->app->singleton(
            SubscriptionMapper::class,
        );

        $this->app->singleton(
            SubscriptionPersistenceAssembler::class,
        );

        $this->app->singleton(
            SubscriptionFactory::class,
        );

        $this->app->singleton(
            SubscriptionRepository::class,
            EloquentSubscriptionRepository::class,
        );
    }
}
