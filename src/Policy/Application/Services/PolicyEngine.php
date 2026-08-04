<?php

declare(strict_types=1);

namespace Vees\Core\Policy\Application\Services;

use Vees\Core\Policy\Domain\Policies\ProviderEligibilityPolicy;

final readonly class PolicyEngine
{
    public function __construct(
        private ProviderEligibilityPolicy $eligibilityPolicy,
    ) {
    }

    /**
     * Evaluate a provider against all active policies.
     * Returns array of actions to take (e.g., suspend, warn).
     */
    public function evaluate(mixed $provider): array
    {
        $actions = [];

        if (!$this->eligibilityPolicy->isEligible($provider)) {
            $actions[] = 'suspend';
        }

        // يمكن إضافة سياسات إضافية هنا لاحقًا

        return $actions;
    }
}
