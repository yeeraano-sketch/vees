<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Domain\Contracts;

use Vees\Core\Payment\Domain\Aggregates\Payment\Payment;
use Vees\Core\Payment\Domain\ValueObjects\PaymentId;

interface PaymentRepository
{
    public function save(
        Payment $payment,
    ): void;

    public function findById(
        PaymentId $id,
    ): ?Payment;

    public function exists(
        PaymentId $id,
    ): bool;

    public function delete(
        Payment $payment,
    ): void;
}
