<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Application\Queries;

use Vees\Core\Framework\Application\Queries\Query;

final readonly class GetNotificationByIdQuery implements Query
{
    public function __construct(
        public string $notificationId,
    ) {
    }
}
