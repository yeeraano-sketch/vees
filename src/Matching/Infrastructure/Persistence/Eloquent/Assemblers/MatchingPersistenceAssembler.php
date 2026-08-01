<?php

declare(strict_types=1);

namespace App\Matching\Infrastructure\Persistence\Eloquent\Assemblers;

use App\Matching\Domain\Aggregates\Matching\Matching;
use App\Matching\Infrastructure\Persistence\Eloquent\Mappers\MatchingMapper;
use App\Matching\Infrastructure\Persistence\Eloquent\Models\MatchingModel;

final readonly class MatchingPersistenceAssembler
{
    public function __construct(
        private MatchingMapper $mapper,
    ) {
    }

    public function persist(
        Matching $matching,
    ): MatchingModel {

        $model = $this->mapper->toModel($matching);

        $model->save();

        return $model;
    }
}
