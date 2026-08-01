<?php

declare(strict_types=1);

namespace App\Subscription\Infrastructure\Persistence\Eloquent\Assemblers;

use App\Subscription\Domain\Aggregates\Subscription\Subscription;
use App\Subscription\Infrastructure\Persistence\Eloquent\Mappers\SubscriptionMapper;
use App\Subscription\Infrastructure\Persistence\Eloquent\Models\SubscriptionModel;

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
