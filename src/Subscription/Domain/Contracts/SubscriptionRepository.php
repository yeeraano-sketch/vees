<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Domain\Contracts;

use Vees\Core\Subscription\Domain\Aggregates\Subscription\Subscription;
use Vees\Core\Subscription\Domain\ValueObjects\SubscriptionId;

interface SubscriptionRepository
{
    public function save(
        Subscription $subscription,
    ): void;

    public function findById(
        SubscriptionId $id,
    ): ?Subscription;

    public function exists(
        SubscriptionId $id,
    ): bool;

    public function delete(
        Subscription $subscription,
    ): void;
}
