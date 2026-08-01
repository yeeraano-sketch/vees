<?php

declare(strict_types=1);

namespace App\Payment\Application\Commands;

use App\Framework\Application\Commands\Command;

final readonly class CreatePaymentCommand implements Command
{
    public function __construct(
        public string $providerId,
        public string $subscriptionId,
        public int $amount,
        public string $currency,
        public string $method,
    ) {
    }
}
