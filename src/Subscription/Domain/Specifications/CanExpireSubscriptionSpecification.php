<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Domain\Specifications;

use Vees\Core\Subscription\Domain\Enums\SubscriptionStatus;

final readonly class CanExpireSubscriptionSpecification
{
    public function isSatisfiedBy(
        SubscriptionStatus $status,
    ): bool {

        return $status === SubscriptionStatus::Active;
    }
}
