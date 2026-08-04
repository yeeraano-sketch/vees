<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Dispatcher;

use Vees\Core\SharedKernel\Application\EventBus\EventBus;
use Vees\Core\SharedKernel\Domain\AggregateRoot;

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

            $aggregate->releaseEvents()

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
