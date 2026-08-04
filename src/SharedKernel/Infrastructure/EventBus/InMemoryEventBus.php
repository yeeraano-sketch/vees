<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Infrastructure\EventBus;

use Vees\Core\SharedKernel\Application\EventBus\EventBus;
use Vees\Core\SharedKernel\Domain\DomainEvent;

final class InMemoryEventBus implements EventBus
{
    /**
     * @var DomainEvent[]
     */
    private array $events = [];

    public function dispatch(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return DomainEvent[]
     */
    public function all(): array
    {
        return $this->events;
    }

    public function count(): int
    {
        return count($this->events);
    }

    public function clear(): void
    {
        $this->events = [];
    }
}
