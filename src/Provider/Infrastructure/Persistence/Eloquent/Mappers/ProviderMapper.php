<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Infrastructure\Persistence\Eloquent\Mappers;

use Vees\Core\Provider\Domain\Aggregates\Provider\Provider;
use Vees\Core\Provider\Infrastructure\Persistence\Eloquent\Models\ProviderModel;

final class ProviderMapper
{
    public function toModel(
        Provider $provider,
        ?ProviderModel $model = null,
    ): ProviderModel {

        $model ??= new ProviderModel;

        $snapshot = $provider->snapshot();

        $model->id = $snapshot['id'];

        $model->full_name = $snapshot['profile']['full_name'];

        $model->phone = $snapshot['profile']['phone'];

        $model->city = $snapshot['profile']['city'];

        $model->work_mode = $snapshot['work_mode'];

        $model->status = $snapshot['verification']['status'];

        $model->verified = $snapshot['verification']['verified'];

        $model->availability = $snapshot['availability']['status'];

        $model->settings = $snapshot['settings'];

        return $model;
    }

    public function toDomain(
        ProviderModel $model,
    ): Provider {

        throw new \LogicException(
            'Hydration is not implemented yet.'
        );
    }
}
