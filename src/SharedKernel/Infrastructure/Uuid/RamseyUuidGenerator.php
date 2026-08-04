<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Infrastructure\Uuid;

use Ramsey\Uuid\Uuid;
use Vees\Core\SharedKernel\Contracts\UuidGenerator;

final readonly class RamseyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid7()->toString();
    }
}
