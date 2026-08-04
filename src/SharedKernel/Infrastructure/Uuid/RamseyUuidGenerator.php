<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Infrastructure\Uuid;

use Vees\Core\SharedKernel\Contracts\UuidGenerator;
use Ramsey\Uuid\Uuid;

final readonly class RamseyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid7()->toString();
    }
}