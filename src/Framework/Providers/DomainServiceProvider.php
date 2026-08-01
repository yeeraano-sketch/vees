<?php

declare(strict_types=1);

namespace App\Framework\Providers;

use Illuminate\Support\ServiceProvider;
use App\Framework\Modules\ModulesRegistry;

final class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        (new ModulesRegistry($this->app))
            ->register();
    }

    public function boot(): void
    {
    }
}
