<?php

declare(strict_types=1);

namespace App\Session\Application\Commands;

use App\Framework\Application\Commands\Command;

final readonly class CreateSessionCommand implements Command
{
    public function __construct(
        public string $providerId,
        public string $customerId,
        public string $matchingId,
        public string $subscriptionId,
    ) {
    }
}
