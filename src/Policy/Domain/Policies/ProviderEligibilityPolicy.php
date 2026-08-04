<?php

declare(strict_types=1);

namespace Vees\Core\Policy\Domain\Policies;

use Vees\Core\SharedKernel\Domain\Contracts\Specification;

final class ProviderEligibilityPolicy
{
    /** @param Specification[] $specifications */
    public function __construct(
        private array $specifications,
    ) {}

    public function isEligible(mixed $provider): bool
    {
        foreach ($this->specifications as $specification) {
            if (! $specification->isSatisfiedBy($provider)) {
                return false;
            }
        }

        return true;
    }
}
