<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\Persistence\Eloquent\Assemblers;

use App\Session\Domain\Aggregates\Session\Session;
use App\Session\Infrastructure\Persistence\Eloquent\Mappers\SessionMapper;
use App\Session\Infrastructure\Persistence\Eloquent\Models\SessionModel;

final readonly class SessionPersistenceAssembler
{
    public function __construct(
        private SessionMapper $mapper,
    ) {
    }

    public function persist(
        Session $session,
    ): SessionModel {

        $model = $this->mapper->toModel($session);

        $model->save();

        return $model;
    }
}
