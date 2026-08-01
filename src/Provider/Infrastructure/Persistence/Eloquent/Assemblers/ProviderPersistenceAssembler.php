<?php

declare(strict_types=1);

namespace App\Provider\Infrastructure\Persistence\Eloquent\Assemblers;

use App\Provider\Domain\Aggregates\Provider\Provider;
use App\Provider\Infrastructure\Persistence\Eloquent\Mappers\ProviderMapper;
use App\Provider\Infrastructure\Persistence\Eloquent\Models\ProviderModel;

final readonly class ProviderPersistenceAssembler
{
    public function __construct(
        private ProviderMapper $mapper,
    ) {
    }

    public function persist(
        Provider $provider,
    ): ProviderModel {

        $model = $this->mapper->toModel($provider);

        $model->save();

        return $model;
    }
}
