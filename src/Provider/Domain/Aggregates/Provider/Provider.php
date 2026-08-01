<?php

declare(strict_types=1);

namespace App\Provider\Domain\Aggregates\Provider;

use App\SharedKernel\Domain\AggregateRoot;
use App\Provider\Domain\Aggregates\Provider\Internal\ProviderState;
use App\Provider\Domain\Entities\ProviderAvailability;
use App\Provider\Domain\Entities\ProviderProfile;
use App\Provider\Domain\Entities\ProviderSettings;
use App\Provider\Domain\Entities\ProviderVerification;
use App\Provider\Domain\Events\ProviderRegistered;
use App\Provider\Domain\ValueObjects\ProviderId;
use App\Provider\Domain\ValueObjects\WorkMode;

final class Provider extends AggregateRoot
{
    private function __construct(
        private ProviderId $id,
        private ProviderState $state,
        private WorkMode $workMode,
    ) {
    }

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

            'id' => (string) \$this->id,

            'profile' => \$this->profile()->toArray(),

            'availability' => \$this->availability()->toArray(),

            'verification' => \$this->verification()->toArray(),

            'settings' => \$this->settings()->toArray(),

            'work_mode' => \$this->workMode()->value,
        ];
    }

}
