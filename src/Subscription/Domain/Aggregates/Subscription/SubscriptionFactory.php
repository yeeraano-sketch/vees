<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Domain\Aggregates\Subscription;

use Vees\Core\Subscription\Domain\Enums\SubscriptionPlan;
use Vees\Core\Subscription\Domain\ValueObjects\SubscriptionId;
use Vees\Core\Subscription\Domain\ValueObjects\SubscriptionPeriod;

final readonly class SubscriptionFactory
{
    public function create(
        SubscriptionId $id,
        string $providerId,
        SubscriptionPlan $plan,
        SubscriptionPeriod $period,
    ): Subscription {

        return Subscription::create(
            id: $id,
            providerId: $providerId,
            plan: $plan,
            period: $period,
        );
    }
}
