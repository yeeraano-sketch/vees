<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\EventBus;

use App\SharedKernel\Application\Events\DomainEvent;
use App\SharedKernel\Application\Subscribers\SubscriberRegistry;

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
