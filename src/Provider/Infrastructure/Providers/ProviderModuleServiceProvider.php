<?php

declare(strict_types=1);

namespace App\Provider\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

use App\Provider\Domain\Contracts\ProviderRepository;
use App\Provider\Infrastructure\Persistence\Eloquent\Repositories\EloquentProviderRepository;

use App\Provider\Domain\Aggregates\Provider\ProviderFactory;

use App\Provider\Infrastructure\Persistence\Eloquent\Mappers\ProviderMapper;
use App\Provider\Infrastructure\Persistence\Eloquent\Assemblers\ProviderPersistenceAssembler;

final class ProviderModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ProviderMapper::class);

        $this->app->singleton(ProviderPersistenceAssembler::class);

        $this->app->singleton(ProviderFactory::class);

        $this->app->singleton(
            ProviderRepository::class,
            EloquentProviderRepository::class,
        );
    }
}
