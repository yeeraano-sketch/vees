<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Integration\Session;

use PHPUnit\Framework\TestCase;
use Vees\Core\Notification\Application\Commands\CreateNotificationCommand;
use Vees\Core\Notification\Application\Services\CreateNotificationService;
use Vees\Core\Notification\Application\Subscribers\SessionCreatedSubscriber;
use Vees\Core\Session\Domain\Events\SessionCreated;
use Vees\Core\SharedKernel\Application\Bus\CommandBusInterface;

final class SessionNotificationContractTest extends TestCase
{
    public function test_notification_is_created_when_session_is_created(): void
    {
        // Arrange
        $bus = $this->createMock(CommandBusInterface::class);
        $bus->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function (CreateNotificationCommand $command) {
                return $command->recipientId === 'session-123'
                    && $command->title === 'Session Created'
                    && str_contains($command->message, 'created successfully');
            }));

        $service = new CreateNotificationService($bus);
        $subscriber = new SessionCreatedSubscriber($service);
        $event = new SessionCreated('session-123');

        // Act
        $subscriber->handle($event);

        // Assert is handled by mock expectation above.
        $this->addToAssertionCount(1);
    }
}
