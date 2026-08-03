<?php

declare(strict_types=1);

namespace App\Provider\Application\Services;

use App\Provider\Application\Commands\RegisterProviderCommand;
use App\Provider\Domain\Aggregates\Provider\Provider;
use App\Provider\Domain\Contracts\ProviderRepository;
use App\Provider\Domain\Aggregates\Provider\ProviderFactory;
use App\Provider\Domain\ValueObjects\ProviderId;
use App\Provider\Domain\ValueObjects\FullName;
use App\Provider\Domain\ValueObjects\PhoneNumber;
use App\Provider\Domain\ValueObjects\City;
use App\Provider\Domain\ValueObjects\WorkMode;
use App\Provider\Domain\ValueObjects\ProviderStatus;
use App\Provider\Domain\Entities\ProviderProfile;
use App\Provider\Domain\Entities\ProviderAvailability;
use App\Provider\Domain\Entities\ProviderVerification;
use App\Provider\Domain\Entities\ProviderSettings;

final readonly class RegisterProviderService
{
    public function __construct(
        private ProviderFactory $factory,
        private ProviderRepository $repository,
    ) {
    }

    public function register(RegisterProviderCommand $command): Provider
    {
        $providerId = new ProviderId($command->id);
        $fullName = new FullName($command->fullName);
        $phoneNumber = new PhoneNumber($command->phoneNumber);
        $city = new City($command->city);
        $workMode = WorkMode::from($command->workMode);

        $profile = new ProviderProfile($fullName, $phoneNumber, $city);
        $availability = new ProviderAvailability();
        $verification = new ProviderVerification();
        $settings = new ProviderSettings();

        $provider = $this->factory->register(
            id: $providerId,
            profile: $profile,
            availability: $availability,
            verification: $verification,
            settings: $settings,
            workMode: $workMode,
        );

        $this->repository->save($provider);

        return $provider;
    }
}
