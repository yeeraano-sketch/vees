<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Domain\Policies;

use Vees\Core\Subscription\Domain\Enums\SubscriptionPlan;

final readonly class PaidSubscriptionPolicy
{
    public function allows(
        SubscriptionPlan $plan,
    ): bool {

        return match ($plan) {

            SubscriptionPlan::Monthly,
            SubscriptionPlan::Quarterly,
            SubscriptionPlan::Yearly => true,

            default => false,
        };
    }
}
