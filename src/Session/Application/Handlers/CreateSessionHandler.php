<?php

declare(strict_types=1);

namespace App\Session\Application\Handlers;

use App\Framework\Persistence\UnitOfWork;
use App\Session\Application\Commands\CreateSessionCommand;
use App\Session\Domain\Aggregates\Session\SessionFactory;
use App\Session\Domain\Contracts\SessionRepository;
use App\Session\Domain\ValueObjects\SessionId;
use App\SharedKernel\Application\Contracts\Command;
use App\SharedKernel\Application\Contracts\CommandHandler;
use App\SharedKernel\Contracts\UuidGenerator;

final readonly class CreateSessionHandler implements CommandHandler
{
    public function __construct(
        private SessionFactory $factory,
        private SessionRepository $repository,
        private UnitOfWork $unitOfWork,
        private UuidGenerator $uuid,
    ) {
    }

    public function handle(
        Command $command,
    ): mixed {

        /** @var CreateSessionCommand $command */

        $session = $this->factory->create(

            id: SessionId::fromString(
                $this->uuid->generate()
            ),

            providerId: $command->providerId,

            customerId: $command->customerId,

            matchingId: $command->matchingId,

            subscriptionId: $command->subscriptionId,
        );

        $this->repository->save($session);

        $this->unitOfWork->commit();

        return $session;
    }
}
