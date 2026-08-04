<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Infrastructure\Providers;

use Illuminate\Contracts\Foundation\Application;

final readonly class IdentityRegistrar
{
    public function __construct(
        private Application $app,
    ) {}

    public function register(): void {}
}
