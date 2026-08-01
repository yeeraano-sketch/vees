<?php

declare(strict_types=1);

namespace App\Session\Domain\Aggregates\Session;

use App\Session\Domain\ValueObjects\SessionId;

final readonly class SessionFactory
{
    public function create(
        SessionId $id,
        string $providerId,
        string $customerId,
        string $matchingId,
        string $subscriptionId,
    ): Session {

        return Session::create(
            id: $id,
            providerId: $providerId,
            customerId: $customerId,
            matchingId: $matchingId,
            subscriptionId: $subscriptionId,
        );
    }
}
