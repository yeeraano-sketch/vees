<?php

declare(strict_types=1);

namespace App\Subscription\Application\Commands;

use App\Framework\Application\Commands\Command;

final readonly class CreateSubscriptionCommand implements Command
{
    public function __construct(
        public string $providerId,
        public string $plan,
    ) {
    }
}
