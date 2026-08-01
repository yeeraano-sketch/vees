<?php

declare(strict_types=1);

namespace App\Matching\Infrastructure\Providers;

use Illuminate\Contracts\Foundation\Application;

use App\Matching\Domain\Contracts\MatchingRepository;
use App\Matching\Domain\Aggregates\Matching\MatchingFactory;

use App\Matching\Infrastructure\Persistence\Eloquent\Assemblers\MatchingPersistenceAssembler;
use App\Matching\Infrastructure\Persistence\Eloquent\Mappers\MatchingMapper;
use App\Matching\Infrastructure\Persistence\Eloquent\Repositories\EloquentMatchingRepository;

final readonly class MatchingRegistrar
{
    public function __construct(
        private Application $app,
    ) {
    }

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
