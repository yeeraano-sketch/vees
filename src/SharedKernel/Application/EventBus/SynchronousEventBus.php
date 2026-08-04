<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\EventBus;

use Vees\Core\SharedKernel\Domain\DomainEvent;
use Vees\Core\SharedKernel\Application\Subscribers\SubscriberRegistry;

final readonly class SynchronousEventBus implements EventBus
{
    public function __construct(
        private SubscriberRegistry $registry,
    ) {
    }

    public function dispatch(
        DomainEvent $event,
    ): void {

        foreach (

            $this->registry->subscribersFor(
                $event::class
            )

            as $subscriber

        ) {

            $subscriber->handle($event);
        }
    }
}
