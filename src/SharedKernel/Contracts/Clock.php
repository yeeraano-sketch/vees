<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Contracts;

use DateTimeImmutable;

interface Clock
{
    public function now(): DateTimeImmutable;
}
