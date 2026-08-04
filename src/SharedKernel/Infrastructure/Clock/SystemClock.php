<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Infrastructure\Clock;

use Vees\Core\SharedKernel\Contracts\Clock;
use DateTimeImmutable;

final readonly class SystemClock implements Clock
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}