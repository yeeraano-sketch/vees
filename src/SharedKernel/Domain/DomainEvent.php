<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain;

interface DomainEvent
{
    public function eventId(): string;

    public function eventType(): string;

    public function entityType(): string;

    public function entityId(): string;

    public function version(): int;

    public function occurredOn(): \DateTimeImmutable;

    public function correlationId(): ?string;

    public function causationId(): ?string;

    public function producer(): string;

    public function payload(): array;
}
