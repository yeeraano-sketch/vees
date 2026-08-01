<?php

declare(strict_types=1);

namespace App\Provider\Application\Handlers;

use App\SharedKernel\Application\Contracts\CommandHandler;

use App\Provider\Application\Commands\RegisterProviderCommand;

use App\Provider\Domain\Aggregates\Provider\ProviderFactory;
use App\Provider\Domain\Contracts\ProviderRepository;
use App\Framework\Persistence\UnitOfWork;
use App\SharedKernel\Contracts\UuidGenerator;

use App\Provider\Domain\ValueObjects\ProviderId;

final readonly class RegisterProviderHandler implements CommandHandler
{
    public function __construct(
        private ProviderFactory $factory,
        private ProviderRepository $repository,
        private UnitOfWork $unitOfWork,
        private UuidGenerator $uuid,
    ) {
    }

    public function handle(
        \App\SharedKernel\Application\Contracts\Command $command,
    ): mixed {

        /** @var RegisterProviderCommand $command */

        $provider = $this->factory->register(

            id: ProviderId::fromString(
                $this->uuid->generate()
            ),

            profile: $command->profile,

            availability: $command->availability,

            verification: $command->verification,

            settings: $command->settings,

            workMode: $command->workMode,
        );

        $this->repository->save($provider);

        $this->unitOfWork->commit();

        return $provider;
    }
}
