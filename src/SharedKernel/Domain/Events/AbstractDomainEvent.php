<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain\Events;

use Vees\Core\SharedKernel\Domain\DomainEvent;
use Ramsey\Uuid\Uuid;

abstract class AbstractDomainEvent implements DomainEvent
{
    private readonly string $eventId;
    private readonly string $aggregateId;
    private readonly \DateTimeImmutable $occurredOn;
    private readonly ?string $correlationId;
    private readonly ?string $causationId;

    public function __construct(
        string $aggregateId,
        ?string $correlationId = null,
        ?string $causationId = null,
    ) {
        $this->eventId = Uuid::uuid7()->toString();
        $this->aggregateId = $aggregateId;
        $this->occurredOn = new \DateTimeImmutable();
        $this->correlationId = $correlationId;
        $this->causationId = $causationId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function eventName(): string
    {
        return class_basename(static::class);
    }

    public function version(): int
    {
        return 1;
    }

    public function eventType(): string
    {
        return static::class;
    }

    public function entityId(): string
    {
        return $this->aggregateId;
    }

    public function correlationId(): ?string
    {
        return $this->correlationId;
    }

    public function causationId(): ?string
    {
        return $this->causationId;
    }

    abstract public function entityType(): string;

    abstract public function producer(): string;

    abstract public function payload(): array;
}
