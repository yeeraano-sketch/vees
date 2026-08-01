<?php

declare(strict_types=1);

namespace App\Provider\Domain\Aggregates\Provider;

use App\Provider\Domain\Entities\ProviderAvailability;
use App\Provider\Domain\Entities\ProviderProfile;
use App\Provider\Domain\Entities\ProviderSettings;
use App\Provider\Domain\Entities\ProviderVerification;
use App\Provider\Domain\ValueObjects\ProviderId;
use App\Provider\Domain\ValueObjects\WorkMode;

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
