<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Domain\Enums;

enum NotificationStatus: string
{
    case Pending = 'pending';

    case Sent = 'sent';

    case Failed = 'failed';
}
