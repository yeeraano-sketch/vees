<?php

declare(strict_types=1);

namespace App\Session\Application\DTOs;

final readonly class SessionDto
{
    public function __construct(
        public string $id,
        public string $providerId,
        public string $customerId,
        public string $matchingId,
        public string $subscriptionId,
        public string $status,
    ) {
    }
}
