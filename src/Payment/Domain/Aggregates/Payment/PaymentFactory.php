<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Domain\Aggregates\Payment;

use Vees\Core\Payment\Domain\Enums\PaymentMethod;
use Vees\Core\Payment\Domain\ValueObjects\Money;
use Vees\Core\Payment\Domain\ValueObjects\PaymentId;

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
