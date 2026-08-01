<?php

declare(strict_types=1);

namespace App\Notification\Domain\Events;

use App\Notification\Domain\ValueObjects\NotificationId;
use App\SharedKernel\Domain\Events\AbstractDomainEvent;

final class NotificationCreated extends AbstractDomainEvent
{
    public function __construct(
        private readonly NotificationId $notificationId,
    ) {
        parent::__construct();
    }

    public function aggregateId(): string
    {
        return (string) $this->notificationId;
    }

    public function payload(): array
    {
        return [
            'notificationId' => (string) $this->notificationId,
        ];
    }
}
