<?php

declare(strict_types=1);

namespace App\Identity\Domain\Events;

use App\SharedKernel\Domain\DomainEvent;

final readonly class UserDeactivated extends DomainEvent
{
    public function __construct(
        public string $userId,
    ) {
        parent::__construct();
    }
}