<?php

declare(strict_types=1);

namespace App\Provider\Domain\Events;

use App\SharedKernel\Domain\DomainEvent;

final readonly class ProviderSuspended extends DomainEvent
{
    public function __construct(
        public string $providerId,
    ) {
        parent::__construct();
    }
}
