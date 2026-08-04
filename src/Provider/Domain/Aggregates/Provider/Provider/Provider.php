<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Aggregates\Provider;

use Vees\Core\Provider\Domain\Aggregates\Provider\Internal\ProviderState;
use Vees\Core\Provider\Domain\Entities\ProviderAvailability;
use Vees\Core\Provider\Domain\Entities\ProviderProfile;
use Vees\Core\Provider\Domain\Entities\ProviderSettings;
use Vees\Core\Provider\Domain\Entities\ProviderVerification;
use Vees\Core\Provider\Domain\Events\ProviderRegistered;
use Vees\Core\Provider\Domain\ValueObjects\ProviderId;
use Vees\Core\Provider\Domain\ValueObjects\WorkMode;
use Vees\Core\SharedKernel\Domain\AggregateRoot;

final class Provider extends AggregateRoot
{
    private function __construct(
        private ProviderId $id,
        private ProviderState $state,
        private WorkMode $workMode,
    ) {}

    public static function register(
        ProviderId $id,
        ProviderProfile $profile,
        ProviderAvailability $availability,
        ProviderVerification $verification,
        ProviderSettings $settings,
        WorkMode $workMode,
    ): self {

        $provider = new self(
            $id,
            new ProviderState(
                $profile,
                $availability,
                $verification,
                $settings,
            ),
            $workMode,
        );

        $provider->recordEvent(
            new ProviderRegistered($id)
        );

        return $provider;
    }

    public function id(): ProviderId
    {
        return $this->id;
    }

    public function workMode(): WorkMode
    {
        return $this->workMode;
    }

    public function profile(): ProviderProfile
    {
        return $this->state->profile;
    }

    public function availability(): ProviderAvailability
    {
        return $this->state->availability;
    }

    public function verification(): ProviderVerification
    {
        return $this->state->verification;
    }

    public function settings(): ProviderSettings
    {
        return $this->state->settings;
    }

    public function snapshot(): array
    {
        return [
            'id' => (string) $this->id,
            'profile' => $this->profile()->toArray(),
            'availability' => $this->availability()->toArray(),
            'verification' => $this->verification()->toArray(),
            'settings' => $this->settings()->toArray(),
            'work_mode' => $this->workMode->value,
        ];
    }
}
