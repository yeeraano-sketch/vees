<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

final class SubscriptionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        (new SubscriptionRegistrar($this->app))->register();
    }
}
