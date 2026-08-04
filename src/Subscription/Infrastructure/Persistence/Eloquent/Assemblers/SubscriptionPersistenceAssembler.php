<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Assemblers;

use Vees\Core\Subscription\Domain\Aggregates\Subscription\Subscription;
use Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Mappers\SubscriptionMapper;
use Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Models\SubscriptionModel;

final readonly class SubscriptionPersistenceAssembler
{
    public function __construct(
        private SubscriptionMapper $mapper,
    ) {
    }

    public function persist(
        Subscription $subscription,
    ): SubscriptionModel {

        $model = $this->mapper->toModel($subscription);

        $model->save();

        return $model;
    }
}
