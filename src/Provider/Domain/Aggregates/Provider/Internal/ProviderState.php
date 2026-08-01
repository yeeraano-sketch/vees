<?php

declare(strict_types=1);

namespace App\Provider\Domain\Aggregates\Provider\Internal;

use App\Provider\Domain\Entities\ProviderAvailability;
use App\Provider\Domain\Entities\ProviderProfile;
use App\Provider\Domain\Entities\ProviderSettings;
use App\Provider\Domain\Entities\ProviderVerification;

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
