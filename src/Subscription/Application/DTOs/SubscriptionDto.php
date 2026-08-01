<?php

declare(strict_types=1);

namespace App\Subscription\Application\DTOs;

final readonly class SubscriptionDto
{
    public function __construct(
        public string $id,
    ) {
    }
}
