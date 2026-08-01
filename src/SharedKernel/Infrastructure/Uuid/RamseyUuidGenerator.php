<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Uuid;

use App\SharedKernel\Contracts\UuidGenerator;
use Ramsey\Uuid\Uuid;

final readonly class RamseyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid7()->toString();
    }
}