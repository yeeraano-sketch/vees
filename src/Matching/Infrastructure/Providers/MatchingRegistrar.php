<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Infrastructure\Providers;

use Illuminate\Contracts\Foundation\Application;
use Vees\Core\Matching\Domain\Aggregates\Matching\MatchingFactory;
use Vees\Core\Matching\Domain\Contracts\MatchingRepository;
use Vees\Core\Matching\Infrastructure\Persistence\Eloquent\Assemblers\MatchingPersistenceAssembler;
use Vees\Core\Matching\Infrastructure\Persistence\Eloquent\Mappers\MatchingMapper;
use Vees\Core\Matching\Infrastructure\Persistence\Eloquent\Repositories\EloquentMatchingRepository;

final readonly class MatchingRegistrar
{
    public function __construct(
        private Application $app,
    ) {}

    public function register(): void
    {
        $this->app->singleton(
            MatchingMapper::class,
        );

        $this->app->singleton(
            MatchingPersistenceAssembler::class,
        );

        $this->app->singleton(
            MatchingFactory::class,
        );

        $this->app->singleton(
            MatchingRepository::class,
            EloquentMatchingRepository::class,
        );
    }
}
