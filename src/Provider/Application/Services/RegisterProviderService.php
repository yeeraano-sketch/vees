<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Application\Services;

use Vees\Core\Provider\Application\Commands\RegisterProviderCommand;
use Vees\Core\Provider\Domain\Aggregates\Provider\Provider;
use Vees\Core\Provider\Domain\Contracts\ProviderRepository;
use Vees\Core\Provider\Domain\Aggregates\Provider\ProviderFactory;
use Vees\Core\Provider\Domain\ValueObjects\ProviderId;
use Vees\Core\Provider\Domain\ValueObjects\FullName;
use Vees\Core\Provider\Domain\ValueObjects\PhoneNumber;
use Vees\Core\Provider\Domain\ValueObjects\City;
use Vees\Core\Provider\Domain\ValueObjects\WorkMode;
use Vees\Core\Provider\Domain\ValueObjects\ProviderStatus;
use Vees\Core\Provider\Domain\Entities\ProviderProfile;
use Vees\Core\Provider\Domain\Entities\ProviderAvailability;
use Vees\Core\Provider\Domain\Entities\ProviderVerification;
use Vees\Core\Provider\Domain\Entities\ProviderSettings;

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
