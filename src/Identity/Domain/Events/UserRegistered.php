<?php

declare(strict_types=1);

namespace App\Identity\Domain\Events;

use App\SharedKernel\Domain\DomainEvent;

final readonly class UserRegistered extends DomainEvent
{
    public function __construct(
        public string $userId,
        public string $email,
        public string $role,
    ) {
        parent::__construct();
    }
}