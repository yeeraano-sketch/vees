<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Clock;

use App\SharedKernel\Contracts\Clock;
use DateTimeImmutable;

final readonly class SystemClock implements Clock
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}