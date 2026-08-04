<?php

declare(strict_types=1);

namespace Vees\Core\Session\Infrastructure\Providers;

use Illuminate\Contracts\Foundation\Application;
use Vees\Core\Session\Domain\Aggregates\Session\SessionFactory;
use Vees\Core\Session\Domain\Contracts\SessionRepository;
use Vees\Core\Session\Infrastructure\Persistence\Eloquent\Assemblers\SessionPersistenceAssembler;
use Vees\Core\Session\Infrastructure\Persistence\Eloquent\Mappers\SessionMapper;
use Vees\Core\Session\Infrastructure\Persistence\Eloquent\Repositories\EloquentSessionRepository;

final readonly class SessionRegistrar
{
    public function __construct(
        private Application $app,
    ) {}

    public function register(): void
    {
        $this->app->singleton(
            SessionMapper::class,
        );

        $this->app->singleton(
            SessionPersistenceAssembler::class,
        );

        $this->app->singleton(
            SessionFactory::class,
        );

        $this->app->singleton(
            SessionRepository::class,
            EloquentSessionRepository::class,
        );
    }
}
