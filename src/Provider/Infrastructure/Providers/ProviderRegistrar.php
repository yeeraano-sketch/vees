<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Infrastructure\Providers;

use Illuminate\Contracts\Foundation\Application;
use Vees\Core\Provider\Domain\Aggregates\Provider\ProviderFactory;
use Vees\Core\Provider\Domain\Contracts\ProviderRepository;
use Vees\Core\Provider\Infrastructure\Persistence\Eloquent\Assemblers\ProviderPersistenceAssembler;
use Vees\Core\Provider\Infrastructure\Persistence\Eloquent\Mappers\ProviderMapper;
use Vees\Core\Provider\Infrastructure\Persistence\Eloquent\Repositories\EloquentProviderRepository;

final readonly class ProviderRegistrar
{
    public function __construct(
        private Application $app,
    ) {}

    public function register(): void
    {
        $this->app->singleton(
            ProviderMapper::class,
        );

        $this->app->singleton(
            ProviderPersistenceAssembler::class,
        );

        $this->app->singleton(
            ProviderFactory::class,
        );

        $this->app->singleton(
            ProviderRepository::class,
            EloquentProviderRepository::class,
        );
    }
}
