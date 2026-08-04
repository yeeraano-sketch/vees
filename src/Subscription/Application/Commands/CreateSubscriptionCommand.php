<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Application\Commands;

use Vees\Core\Framework\Application\Commands\Command;

final readonly class CreateSubscriptionCommand implements Command
{
    public function __construct(
        public string $providerId,
        public string $plan,
    ) {
    }
}
