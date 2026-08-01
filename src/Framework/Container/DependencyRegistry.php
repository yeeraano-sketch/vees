<?php

declare(strict_types=1);

namespace App\Framework\Container;

use Illuminate\Contracts\Foundation\Application;

final readonly class DependencyRegistry
{
    public function __construct(
        private Application $app,
    ) {
    }

    public function singleton(
        string $abstract,
        string $concrete,
    ): void {

        $this->app->singleton($abstract, $concrete);
    }

    public function bind(
        string $abstract,
        string $concrete,
    ): void {

        $this->app->bind($abstract, $concrete);
    }
}
