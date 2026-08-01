<?php

declare(strict_types=1);

namespace App\Notification\Application\DTOs;

final readonly class NotificationDto
{
    public function __construct(
        public string $id,
        public string $recipientId,
        public string $title,
        public string $message,
        public string $status,
    ) {
    }
}
