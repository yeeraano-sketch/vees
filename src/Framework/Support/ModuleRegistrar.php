<?php

declare(strict_types=1);

namespace App\Framework\Support;

use App\Framework\Container\DependencyRegistry;

final readonly class ModuleRegistrar
{
    public function __construct(
        private DependencyRegistry $registry,
    ) {
    }

    public function singleton(
        string $abstract,
        string $implementation,
    ): void {

        $this->registry->singleton(
            $abstract,
            $implementation,
        );
    }

    public function bind(
        string $abstract,
        string $implementation,
    ): void {

        $this->registry->bind(
            $abstract,
            $implementation,
        );
    }
}
