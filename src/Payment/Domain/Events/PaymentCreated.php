<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Domain\Events;

use Vees\Core\SharedKernel\Domain\Events\AbstractDomainEvent;

final class PaymentCreated extends AbstractDomainEvent
{
    public function __construct(string $paymentId, ?string $correlationId = null, ?string $causationId = null)
    {
        parent::__construct($paymentId, $correlationId, $causationId);
    }

    public function entityType(): string
    {
        return 'Payment';
    }

    public function producer(): string
    {
        return 'PaymentModule';
    }

    public function payload(): array
    {
        return ['paymentId' => $this->entityId()];
    }
}
