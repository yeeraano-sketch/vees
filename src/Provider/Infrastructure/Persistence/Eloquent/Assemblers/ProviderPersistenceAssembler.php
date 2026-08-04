<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Infrastructure\Persistence\Eloquent\Assemblers;

use Vees\Core\Provider\Domain\Aggregates\Provider\Provider;
use Vees\Core\Provider\Infrastructure\Persistence\Eloquent\Mappers\ProviderMapper;
use Vees\Core\Provider\Infrastructure\Persistence\Eloquent\Models\ProviderModel;

final readonly class ProviderPersistenceAssembler
{
    public function __construct(
        private ProviderMapper $mapper,
    ) {}

    public function persist(
        Provider $provider,
    ): ProviderModel {

        $model = $this->mapper->toModel($provider);

        $model->save();

        return $model;
    }
}
