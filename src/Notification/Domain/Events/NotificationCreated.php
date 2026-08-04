<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Domain\Events;

use Vees\Core\SharedKernel\Domain\Events\AbstractDomainEvent;

final class NotificationCreated extends AbstractDomainEvent
{
    public function __construct(string $notificationId, ?string $correlationId = null, ?string $causationId = null)
    {
        parent::__construct($notificationId, $correlationId, $causationId);
    }

    public function entityType(): string
    {
        return 'Notification';
    }

    public function producer(): string
    {
        return 'NotificationEngine';
    }

    public function payload(): array
    {
        return ['notificationId' => $this->entityId()];
    }
}
