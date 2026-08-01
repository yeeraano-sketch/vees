<?php

declare(strict_types=1);

namespace App\Matching\Infrastructure\Persistence\Eloquent\Mappers;

use App\Matching\Domain\Aggregates\Matching\Matching;
use App\Matching\Infrastructure\Persistence\Eloquent\Models\MatchingModel;

final class MatchingMapper
{
    public function toModel(
        Matching $matching,
        ?MatchingModel $model = null,
    ): MatchingModel {

        $model ??= new MatchingModel();

        $snapshot = $matching->snapshot();

        $model->id = $snapshot['id'];

        $model->session_id = $snapshot['session_id'];

        $model->provider_id = $snapshot['provider_id'];

        $model->status = $snapshot['status'];

        return $model;
    }

    public function toDomain(
        MatchingModel $model,
    ): Matching {

        throw new \LogicException(
            'Hydration is not implemented yet.'
        );
    }
}
