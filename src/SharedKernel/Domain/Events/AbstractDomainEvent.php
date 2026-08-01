<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Events;

use App\SharedKernel\Domain\DomainEvent;
use Ramsey\Uuid\Uuid;

abstract class AbstractDomainEvent implements DomainEvent
{
    private readonly string $eventId;

    private readonly \DateTimeImmutable $occurredOn;

    final public function __construct()
    {
        $this->eventId = Uuid::uuid7()->toString();
        $this->occurredOn = new \DateTimeImmutable();
    }

    final public function eventId(): string
    {
        return $this->eventId;
    }

    final public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    final public function eventName(): string
    {
        return class_basename(static::class);
    }

    public function version(): int
    {
        return 1;
    }

    abstract public function aggregateId(): string;

    abstract public function payload(): array;
}
