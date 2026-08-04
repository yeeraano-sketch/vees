<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Specifications;

use Vees\Core\Provider\Domain\Contracts\AvailabilityInterface;
use Vees\Core\Provider\Domain\Enums\AvailabilityStatus;

final class CanAcceptSessionSpecification
{
    public function isSatisfiedBy(
        AvailabilityInterface $availability,
        int $activeSessionsCount,
    ): bool {
        if ($availability->status() !== AvailabilityStatus::Available) {
            return false;
        }

        return $activeSessionsCount === 0;
    }
}
