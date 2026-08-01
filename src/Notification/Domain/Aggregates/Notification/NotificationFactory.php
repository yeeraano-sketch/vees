<?php

declare(strict_types=1);

namespace App\Notification\Domain\Aggregates\Notification;

use App\Notification\Domain\ValueObjects\NotificationId;

final readonly class NotificationFactory
{
    public function create(
        NotificationId $id,
        string $recipientId,
        string $title,
        string $message,
    ): Notification {

        return Notification::create(
            id: $id,
            recipientId: $recipientId,
            title: $title,
            message: $message,
        );
    }
}
