<?php

declare(strict_types=1);

namespace App\Notification\Application\Subscribers;

use App\Notification\Application\Commands\CreateNotificationCommand;
use App\Notification\Application\Services\CreateNotificationService;
use App\Session\Domain\Events\SessionCreated;
use App\SharedKernel\Application\Events\DomainEvent;
use App\SharedKernel\Application\Subscribers\EventSubscriber;

final readonly class SessionCreatedSubscriber implements EventSubscriber
{
    public function __construct(
        private CreateNotificationService $service,
    ) {
    }

    public static function subscribeTo(): string
    {
        return SessionCreated::class;
    }

    public function handle(
        DomainEvent $event,
    ): void {

        /** @var SessionCreated $event */

        $this->service->create(

            new CreateNotificationCommand(

                recipientId: $event->aggregateId(),

                title: 'Session Created',

                message: 'Your session has been created successfully.',

            )

        );
    }
}
