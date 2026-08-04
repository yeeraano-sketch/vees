<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Repositories;

use Vees\Core\Subscription\Domain\Aggregates\Subscription\Subscription;
use Vees\Core\Subscription\Domain\Contracts\SubscriptionRepository;
use Vees\Core\Subscription\Domain\ValueObjects\SubscriptionId;
use Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Assemblers\SubscriptionPersistenceAssembler;
use Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Models\SubscriptionModel;
use Vees\Core\SharedKernel\Application\Transactions\AggregateCollector;

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
