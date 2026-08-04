<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

final class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        (new NotificationRegistrar($this->app))->register();
    }
}
