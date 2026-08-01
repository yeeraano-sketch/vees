<?php

declare(strict_types=1);

namespace App\Identity\Infrastructure\Providers;

use App\Identity\Domain\Repositories\UserRepository;
use App\Identity\Infrastructure\Persistence\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

final class IdentityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepository::class,
            EloquentUserRepository::class,
        );
    }

    public function boot(): void
    {
    }
}
