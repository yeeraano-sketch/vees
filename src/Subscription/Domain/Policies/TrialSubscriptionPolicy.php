<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Domain\Policies;

use Vees\Core\Subscription\Domain\Enums\SubscriptionPlan;

final readonly class TrialSubscriptionPolicy
{
    public function allows(
        SubscriptionPlan $plan,
    ): bool {

        return $plan === SubscriptionPlan::Trial;
    }
}
