<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Traits;

use App\SharedKernel\Domain\DomainEvent;

trait RecordsEvents
{
    /** @var DomainEvent[] */
    private array $recordedEvents = [];

    final protected function record(DomainEvent $event): void
    {
        $this->recordedEvents[] = $event;
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
}
