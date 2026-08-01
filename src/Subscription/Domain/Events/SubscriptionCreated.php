<?php

declare(strict_types=1);

namespace App\Subscription\Domain\Events;

use App\SharedKernel\Domain\Events\AbstractDomainEvent;
use App\Subscription\Domain\ValueObjects\SubscriptionId;

final class SubscriptionCreated extends AbstractDomainEvent
{
    public function __construct(
        private readonly SubscriptionId $subscriptionId,
    ) {
        parent::__construct();
    }

    public function aggregateId(): string
    {
        return (string) $this->subscriptionId;
    }

    public function payload(): array
    {
        return [
            'subscriptionId' => (string) $this->subscriptionId,
        ];
    }
}
