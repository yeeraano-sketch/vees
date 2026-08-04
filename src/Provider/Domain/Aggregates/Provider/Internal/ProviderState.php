<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Aggregates\Provider\Internal;

use Vees\Core\Provider\Domain\Entities\ProviderAvailability;
use Vees\Core\Provider\Domain\Entities\ProviderProfile;
use Vees\Core\Provider\Domain\Entities\ProviderSettings;
use Vees\Core\Provider\Domain\Entities\ProviderVerification;

final class ProviderState
{
    public function __construct(
        public ProviderProfile $profile,
        public ProviderAvailability $availability,
        public ProviderVerification $verification,
        public ProviderSettings $settings,
    ) {
    }
}
