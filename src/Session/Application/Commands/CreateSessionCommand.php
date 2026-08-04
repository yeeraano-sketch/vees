<?php

declare(strict_types=1);

namespace Vees\Core\Session\Application\Commands;

use Vees\Core\SharedKernel\Application\Contracts\Command;

final readonly class CreateSessionCommand implements Command
{
    public function __construct(
        public string $id,
        public string $providerId,
        public string $customerId,
        public string $matchingId,
        public string $subscriptionId,
    ) {
    }
}
