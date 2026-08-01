<?php

declare(strict_types=1);

namespace App\Notification\Application\Queries;

use App\Framework\Application\Queries\Query;

final readonly class GetNotificationByIdQuery implements Query
{
    public function __construct(
        public string $notificationId,
    ) {
    }
}
