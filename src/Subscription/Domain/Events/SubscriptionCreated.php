<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Domain\Events;

use Vees\Core\SharedKernel\Domain\Events\AbstractDomainEvent;

final class SubscriptionCreated extends AbstractDomainEvent
{
    public function __construct(string $subscriptionId, ?string $correlationId = null, ?string $causationId = null)
    {
        parent::__construct($subscriptionId, $correlationId, $causationId);
    }

    public function entityType(): string
    {
        return 'Subscription';
    }

    public function producer(): string
    {
        return 'SubscriptionModule';
    }

    public function payload(): array
    {
        return ['subscriptionId' => $this->entityId()];
    }
}
