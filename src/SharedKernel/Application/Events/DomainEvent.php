<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Events;

interface DomainEvent
{
    public function aggregateId(): string;

    public function occurredOn(): \DateTimeImmutable;

    public function payload(): array;
}
