<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Infrastructure\Persistence\Eloquent\Assemblers;

use Vees\Core\Matching\Domain\Aggregates\Matching\Matching;
use Vees\Core\Matching\Infrastructure\Persistence\Eloquent\Mappers\MatchingMapper;
use Vees\Core\Matching\Infrastructure\Persistence\Eloquent\Models\MatchingModel;

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
