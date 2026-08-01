<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Dispatcher;

use App\SharedKernel\Application\EventBus\EventBus;
use App\SharedKernel\Domain\AggregateRoot;

final readonly class EventDispatcher
{
    public function __construct(
        private EventBus $bus,
    ) {
    }

    public function dispatchFrom(
        AggregateRoot $aggregate,
    ): void {

        foreach (

            $aggregate->pullEvents()

            as $event

        ) {

            $this->bus->dispatch($event);

        }
    }

    /**
     * @param iterable<AggregateRoot> $aggregates
     */
    public function dispatchAll(
        iterable $aggregates,
    ): void {

        foreach ($aggregates as $aggregate) {

            $this->dispatchFrom($aggregate);

        }
    }
}
