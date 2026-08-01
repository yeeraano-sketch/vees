<?php

declare(strict_types=1);

namespace App\Subscription\Infrastructure\Persistence\Eloquent\Repositories;

use App\Subscription\Domain\Aggregates\Subscription\Subscription;
use App\Subscription\Domain\Contracts\SubscriptionRepository;
use App\Subscription\Domain\ValueObjects\SubscriptionId;
use App\Subscription\Infrastructure\Persistence\Eloquent\Assemblers\SubscriptionPersistenceAssembler;
use App\Subscription\Infrastructure\Persistence\Eloquent\Models\SubscriptionModel;
use App\SharedKernel\Application\Transactions\AggregateCollector;

final readonly class EloquentSubscriptionRepository implements SubscriptionRepository
{
    public function __construct(
        private SubscriptionPersistenceAssembler $assembler,
        private AggregateCollector $collector,
    ) {
    }

    public function save(
        Subscription $subscription,
    ): void {

        $this->assembler->persist($subscription);

        $this->collector->add($subscription);
    }

    public function findById(
        SubscriptionId $id,
    ): ?Subscription {

        // سيتم تنفيذ Hydration لاحقًا.
        return null;
    }

    public function exists(
        SubscriptionId $id,
    ): bool {

        return SubscriptionModel::query()
            ->whereKey((string) $id)
            ->exists();
    }

    public function delete(
        Subscription $subscription,
    ): void {

        SubscriptionModel::query()
            ->whereKey((string) $subscription->id())
            ->delete();
    }
}
