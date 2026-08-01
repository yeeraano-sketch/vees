<?php

declare(strict_types=1);

namespace App\Provider\Domain\Aggregates\Provider\Events;

use App\SharedKernel\Domain\DomainEvent;

final readonly class WorkModeChanged extends DomainEvent
{
    public function __construct(
        public string $providerId,
        public string $workMode,
    ) {
        parent::__construct();
    }
}
