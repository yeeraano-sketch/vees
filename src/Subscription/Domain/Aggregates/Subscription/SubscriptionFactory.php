<?php

declare(strict_types=1);

namespace App\Subscription\Domain\Aggregates\Subscription;

use App\Subscription\Domain\Enums\SubscriptionPlan;
use App\Subscription\Domain\ValueObjects\SubscriptionId;
use App\Subscription\Domain\ValueObjects\SubscriptionPeriod;

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
