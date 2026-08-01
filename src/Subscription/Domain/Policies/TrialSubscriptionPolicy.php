<?php

declare(strict_types=1);

namespace App\Subscription\Domain\Policies;

use App\Subscription\Domain\Enums\SubscriptionPlan;

final readonly class TrialSubscriptionPolicy
{
    public function allows(
        SubscriptionPlan $plan,
    ): bool {

        return $plan === SubscriptionPlan::Trial;
    }
}
