<?php

declare(strict_types=1);

namespace App\Subscription\Domain\Enums;

enum SubscriptionStatus: string
{
    case Pending = 'pending';

    case Active = 'active';

    case Expired = 'expired';

    case Cancelled = 'cancelled';

    case Suspended = 'suspended';
}
