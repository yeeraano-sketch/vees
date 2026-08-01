<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain;

interface DomainEvent
{
    public function eventId(): string;

    public function aggregateId(): string;

    public function occurredOn(): \DateTimeImmutable;

    public function eventName(): string;

    public function payload(): array;
}
