<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Infrastructure\Providers;

use Illuminate\Contracts\Foundation\Application;

use Vees\Core\Notification\Domain\Contracts\NotificationRepository;
use Vees\Core\Notification\Domain\Aggregates\Notification\NotificationFactory;

use Vees\Core\Notification\Infrastructure\Persistence\Eloquent\Assemblers\NotificationPersistenceAssembler;
use Vees\Core\Notification\Infrastructure\Persistence\Eloquent\Mappers\NotificationMapper;
use Vees\Core\Notification\Infrastructure\Persistence\Eloquent\Repositories\EloquentNotificationRepository;

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
