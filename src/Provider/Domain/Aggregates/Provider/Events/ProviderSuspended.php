<?php

declare(strict_types=1);

namespace App\Provider\Domain\Aggregates\Provider\Events;

use App\Provider\Domain\ValueObjects\ProviderId;
use App\SharedKernel\Domain\Events\AbstractDomainEvent;

final class ProviderSuspended extends AbstractDomainEvent
{
    public function __construct(
        private readonly ProviderId $providerId,
        private readonly string $reason,
    ) {
        parent::__construct();
    }

    public function aggregateId(): string
    {
        return (string) $this->providerId;
    }

    public function payload(): array
    {
        return [
            'providerId' => (string) $this->providerId,
            'reason' => $this->reason,
        ];
    }
}
