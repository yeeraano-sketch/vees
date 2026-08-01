<?php

declare(strict_types=1);

namespace App\Payment\Domain\Events;

use App\Payment\Domain\ValueObjects\PaymentId;
use App\SharedKernel\Domain\Events\AbstractDomainEvent;

final class PaymentCreated extends AbstractDomainEvent
{
    public function __construct(
        private readonly PaymentId $paymentId,
    ) {
        parent::__construct();
    }

    public function aggregateId(): string
    {
        return (string) $this->paymentId;
    }

    public function payload(): array
    {
        return [
            'paymentId' => (string) $this->paymentId,
        ];
    }
}
