<?php

declare(strict_types=1);

namespace App\Subscription\Domain\Enums;

enum SubscriptionPlan: string
{
    case Trial = 'trial';

    case Monthly = 'monthly';

    case Quarterly = 'quarterly';

    case Yearly = 'yearly';
}
