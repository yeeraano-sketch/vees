<?php

declare(strict_types=1);

namespace Vees\Core\Session\Domain\Aggregates\Session;

use Vees\Core\Session\Domain\ValueObjects\SessionId;

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
