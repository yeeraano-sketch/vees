<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Mappers;

use Vees\Core\Subscription\Domain\Aggregates\Subscription\Subscription;
use Vees\Core\Subscription\Infrastructure\Persistence\Eloquent\Models\SubscriptionModel;

final class SubscriptionMapper
{
    public function toModel(
        Subscription $subscription,
        ?SubscriptionModel $model = null,
    ): SubscriptionModel {

        $model ??= new SubscriptionModel;

        $snapshot = $subscription->snapshot();

        $model->id = $snapshot['id'];

        $model->provider_id = $snapshot['provider_id'];

        $model->plan = $snapshot['plan'];

        return $model;
    }

    public function toDomain(
        SubscriptionModel $model,
    ): Subscription {

        throw new \LogicException(
            'Hydration is not implemented yet.'
        );
    }
}
