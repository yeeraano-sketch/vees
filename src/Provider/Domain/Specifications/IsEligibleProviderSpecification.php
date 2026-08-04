<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Specifications;

use Vees\Core\Provider\Domain\Aggregates\Provider\Provider;
use Vees\Core\Provider\Domain\Enums\ProviderStatus;

final class IsEligibleProviderSpecification
{
    public function isSatisfiedBy(Provider $provider): bool
    {
        $status = $provider->snapshot()['status'] ?? null;

        return $status === ProviderStatus::Active->value;
    }
}
