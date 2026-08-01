<?php

declare(strict_types=1);

namespace App\Provider\Application\Handlers;

use App\Provider\Application\Commands\RegisterProviderCommand;
use App\Provider\Domain\Aggregates\Provider\ProviderFactory;
use App\Provider\Domain\Contracts\ProviderRepository;
use App\SharedKernel\Application\Contracts\CommandHandler;

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
