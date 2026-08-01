<?php

declare(strict_types=1);

namespace App\Provider\Application\Services;

use App\Framework\Persistence\UnitOfWork;
use App\Provider\Application\Commands\RegisterProviderCommand;
use App\Provider\Domain\Aggregates\Provider\ProviderFactory;
use App\Provider\Domain\Contracts\ProviderRepository;
use App\SharedKernel\Contracts\Clock;
use App\SharedKernel\Contracts\UuidGenerator;
use App\Provider\Domain\ValueObjects\ProviderId;
use App\SharedKernel\Domain\Result;

final readonly class RegisterProviderService
{
    public function __construct(
        private ProviderFactory $factory,
        private ProviderRepository $repository,
        private UnitOfWork $unitOfWork,
        private UuidGenerator $uuid,
        private Clock $clock,
    ) {
    }

    public function register(RegisterProviderCommand $command): Result
    {
        $this->unitOfWork->begin();

        try {

            $provider = $this->factory->register(
                id: ProviderId::fromString($this->uuid->generate()),
                profile: $command->profile,
                availability: $command->availability,
                verification: $command->verification,
                settings: $command->settings,
                workMode: $command->workMode,
            );

            $this->repository->save($provider);

            return $this->unitOfWork->commit();

        } catch (\Throwable $e) {

            $this->unitOfWork->rollback();

            throw $e;
        }
    }
}
