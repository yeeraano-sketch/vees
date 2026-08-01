<?php

declare(strict_types=1);

namespace App\Payment\Infrastructure\Persistence\Eloquent\Mappers;

use App\Payment\Domain\Aggregates\Payment\Payment;
use App\Payment\Infrastructure\Persistence\Eloquent\Models\PaymentModel;

final class PaymentMapper
{
    public function toModel(
        Payment $payment,
        ?PaymentModel $model = null,
    ): PaymentModel {

        $model ??= new PaymentModel();

        $snapshot = $payment->snapshot();

        $model->id = $snapshot['id'];

        $model->provider_id = $snapshot['provider_id'];

        $model->subscription_id = $snapshot['subscription_id'];

        $model->amount = $snapshot['amount'];

        $model->method = $snapshot['method'];

        $model->status = $snapshot['status'];

        return $model;
    }

    public function toDomain(
        PaymentModel $model,
    ): Payment {

        throw new \LogicException(
            'Hydration is not implemented yet.'
        );
    }
}
