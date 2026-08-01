<?php

declare(strict_types=1);

namespace App\Payment\Domain\Contracts;

use App\Payment\Domain\Aggregates\Payment\Payment;
use App\Payment\Domain\ValueObjects\PaymentId;

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
