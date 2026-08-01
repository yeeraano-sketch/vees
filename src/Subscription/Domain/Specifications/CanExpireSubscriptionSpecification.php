<?php

declare(strict_types=1);

namespace App\Subscription\Domain\Specifications;

use App\Subscription\Domain\Enums\SubscriptionStatus;

final readonly class CanExpireSubscriptionSpecification
{
    public function isSatisfiedBy(
        SubscriptionStatus $status,
    ): bool {

        return $status === SubscriptionStatus::Active;
    }
}
