<?php

declare(strict_types=1);

namespace App\Payment\Infrastructure\Persistence\Eloquent\Assemblers;

use App\Payment\Domain\Aggregates\Payment\Payment;
use App\Payment\Infrastructure\Persistence\Eloquent\Mappers\PaymentMapper;
use App\Payment\Infrastructure\Persistence\Eloquent\Models\PaymentModel;

final readonly class PaymentPersistenceAssembler
{
    public function __construct(
        private PaymentMapper $mapper,
    ) {
    }

    public function persist(
        Payment $payment,
    ): PaymentModel {

        $model = $this->mapper->toModel($payment);

        $model->save();

        return $model;
    }
}
