<?php

declare(strict_types=1);

namespace App\Subscription\Domain\Contracts;

use App\Subscription\Domain\Aggregates\Subscription\Subscription;
use App\Subscription\Domain\ValueObjects\SubscriptionId;

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
