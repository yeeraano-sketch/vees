<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Specifications;

use Vees\Core\Provider\Domain\Aggregates\Provider\Provider;
use Vees\Core\Provider\Domain\Entities\ProviderAvailability;
use Vees\Core\Session\Domain\Enums\SessionStatus;

final class CanAcceptSessionSpecification
{
    /**
     * Checks if a provider is eligible to accept a new session.
     *
     * Rule: Provider cannot have more than one active session.
     * Active sessions are those not yet completed or cancelled.
     */
    public function isSatisfiedBy(
        Provider $provider,
        int $activeSessionsCount,
    ): bool {
        if ($provider->availability()->status() !== \App\Provider\Domain\Enums\AvailabilityStatus::Online) {
            return false;
        }

        return $activeSessionsCount === 0;
    }
}
