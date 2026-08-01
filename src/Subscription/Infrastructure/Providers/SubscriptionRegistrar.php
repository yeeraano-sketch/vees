<?php

declare(strict_types=1);

namespace App\Subscription\Infrastructure\Providers;

use Illuminate\Contracts\Foundation\Application;

use App\Subscription\Domain\Contracts\SubscriptionRepository;
use App\Subscription\Domain\Aggregates\Subscription\SubscriptionFactory;

use App\Subscription\Infrastructure\Persistence\Eloquent\Assemblers\SubscriptionPersistenceAssembler;
use App\Subscription\Infrastructure\Persistence\Eloquent\Mappers\SubscriptionMapper;
use App\Subscription\Infrastructure\Persistence\Eloquent\Repositories\EloquentSubscriptionRepository;

final readonly class SubscriptionRegistrar
{
    public function __construct(
        private Application $app,
    ) {
    }

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
