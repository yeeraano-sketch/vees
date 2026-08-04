<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Domain\Enums;

enum SubscriptionPlan: string
{
    case Trial = 'trial';

    case Monthly = 'monthly';

    case Quarterly = 'quarterly';

    case Yearly = 'yearly';
}
