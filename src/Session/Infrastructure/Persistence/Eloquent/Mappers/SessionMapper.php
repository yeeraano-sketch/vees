<?php

declare(strict_types=1);

namespace Vees\Core\Session\Infrastructure\Persistence\Eloquent\Mappers;

use Vees\Core\Session\Domain\Aggregates\Session\Session;
use Vees\Core\Session\Infrastructure\Persistence\Eloquent\Models\SessionModel;

final class SessionMapper
{
    public function toModel(
        Session $session,
        ?SessionModel $model = null,
    ): SessionModel {

        $model ??= new SessionModel();

        $snapshot = $session->snapshot();

        $model->id = $snapshot['id'];

        $model->provider_id = $snapshot['provider_id'];

        $model->customer_id = $snapshot['customer_id'];

        $model->matching_id = $snapshot['matching_id'];

        $model->subscription_id = $snapshot['subscription_id'];

        $model->status = $snapshot['status'];

        return $model;
    }

    public function toDomain(
        SessionModel $model,
    ): Session {

        throw new \LogicException(
            'Hydration is not implemented yet.'
        );
    }
}
