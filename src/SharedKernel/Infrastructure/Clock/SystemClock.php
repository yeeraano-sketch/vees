<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Infrastructure\Clock;

use DateTimeImmutable;
use Vees\Core\SharedKernel\Contracts\Clock;

final readonly class SystemClock implements Clock
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable;
    }
}
