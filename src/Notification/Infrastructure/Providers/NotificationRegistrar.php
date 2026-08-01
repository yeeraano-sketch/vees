<?php

declare(strict_types=1);

namespace App\Notification\Infrastructure\Providers;

use Illuminate\Contracts\Foundation\Application;

use App\Notification\Domain\Contracts\NotificationRepository;
use App\Notification\Domain\Aggregates\Notification\NotificationFactory;

use App\Notification\Infrastructure\Persistence\Eloquent\Assemblers\NotificationPersistenceAssembler;
use App\Notification\Infrastructure\Persistence\Eloquent\Mappers\NotificationMapper;
use App\Notification\Infrastructure\Persistence\Eloquent\Repositories\EloquentNotificationRepository;

final readonly class NotificationRegistrar
{
    public function __construct(
        private Application $app,
    ) {
    }

    public function register(): void
    {
        $this->app->singleton(
            NotificationMapper::class,
        );

        $this->app->singleton(
            NotificationPersistenceAssembler::class,
        );

        $this->app->singleton(
            NotificationFactory::class,
        );

        $this->app->singleton(
            NotificationRepository::class,
            EloquentNotificationRepository::class,
        );
    }
}
