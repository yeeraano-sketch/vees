<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain\Traits;

use Vees\Core\SharedKernel\Domain\DomainEvent;

trait RecordsEvents
{
    /** @var DomainEvent[] */
    private array $recordedEvents = [];

    final protected function record(
        DomainEvent $event,
    ): void {

        $this->recordedEvents[] = $event;
    }

    final protected function recordEvent(
        DomainEvent $event,
    ): void {

        $this->record($event);
    }

    /**
     * @return DomainEvent[]
     */
    final public function releaseEvents(): array
    {
        $events = $this->recordedEvents;

        $this->recordedEvents = [];

        return $events;
    }

    /**
     * @return DomainEvent[]
     */
    final public function pullEvents(): array
    {
        return $this->releaseEvents();
    }
}
