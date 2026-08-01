<?php

declare(strict_types=1);

namespace App\Payment\Domain\Aggregates\Payment;

use App\Payment\Domain\Enums\PaymentMethod;
use App\Payment\Domain\ValueObjects\Money;
use App\Payment\Domain\ValueObjects\PaymentId;

final readonly class PaymentFactory
{
    public function create(
        PaymentId $id,
        string $providerId,
        string $subscriptionId,
        Money $money,
        PaymentMethod $method,
    ): Payment {

        return Payment::create(
            id: $id,
            providerId: $providerId,
            subscriptionId: $subscriptionId,
            money: $money,
            method: $method,
        );
    }
}
