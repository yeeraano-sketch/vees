<?php

declare(strict_types=1);

namespace App\Framework\Modules;

use Illuminate\Contracts\Foundation\Application;

use App\Provider\Domain\Contracts\ProviderRepository;
use App\Provider\Domain\Aggregates\Provider\ProviderFactory;
use App\Provider\Infrastructure\Persistence\Eloquent\Mappers\ProviderMapper;
use App\Provider\Infrastructure\Persistence\Eloquent\Assemblers\ProviderPersistenceAssembler;
use App\Provider\Infrastructure\Persistence\Eloquent\Repositories\EloquentProviderRepository;

final readonly class ModulesRegistry
{
    public function __construct(
        private Application $app,
    ) {
    }

    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Provider Module
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(ProviderMapper::class);

        $this->app->singleton(ProviderPersistenceAssembler::class);

        $this->app->singleton(ProviderFactory::class);

        $this->app->singleton(
            ProviderRepository::class,
            EloquentProviderRepository::class,
        );
    }
}
