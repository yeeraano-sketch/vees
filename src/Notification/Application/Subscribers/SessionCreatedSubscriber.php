<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Application\Subscribers;

use Vees\Core\Notification\Application\Commands\CreateNotificationCommand;
use Vees\Core\Notification\Application\Services\CreateNotificationService;
use Vees\Core\Session\Domain\Events\SessionCreated;
use Vees\Core\SharedKernel\Domain\DomainEvent;
use Vees\Core\SharedKernel\Application\Subscribers\EventSubscriber;

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
