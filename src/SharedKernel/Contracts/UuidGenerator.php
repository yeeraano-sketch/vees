<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Contracts;

interface UuidGenerator
{
    public function generate(): string;
}
