<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Application\Handlers;

use Vees\Core\Provider\Application\Commands\RegisterProviderCommand;
use Vees\Core\Provider\Domain\Aggregates\Provider\ProviderFactory;
use Vees\Core\Provider\Domain\Contracts\ProviderRepository;
use Vees\Core\SharedKernel\Application\Contracts\CommandHandler;

final readonly class RegisterProviderHandler implements CommandHandler
{
    public function __construct(
        private ProviderFactory $factory,
        private ProviderRepository $repository,
    ) {
    }

    public function handle(
        RegisterProviderCommand $command,
    ): void {

        $provider = $this->factory->register(

            fullName: $command->fullName,

            phoneNumber: $command->phoneNumber,

            city: $command->city,

            workMode: $command->workMode,

        );

        $this->repository->save($provider);
    }
}
