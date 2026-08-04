<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Aggregates\Provider;

use Vees\Core\Provider\Domain\Entities\ProviderAvailability;
use Vees\Core\Provider\Domain\Entities\ProviderProfile;
use Vees\Core\Provider\Domain\Entities\ProviderSettings;
use Vees\Core\Provider\Domain\Entities\ProviderVerification;
use Vees\Core\Provider\Domain\ValueObjects\ProviderId;
use Vees\Core\Provider\Domain\ValueObjects\WorkMode;

final readonly class ProviderFactory
{
    public function register(
        ProviderId $id,
        ProviderProfile $profile,
        ProviderAvailability $availability,
        ProviderVerification $verification,
        ProviderSettings $settings,
        WorkMode $workMode,
    ): Provider {
        return Provider::register(
            id: $id,
            profile: $profile,
            availability: $availability,
            verification: $verification,
            settings: $settings,
            workMode: $workMode,
        );
    }
}
