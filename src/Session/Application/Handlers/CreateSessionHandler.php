<?php

declare(strict_types=1);

namespace Vees\Core\Session\Application\Handlers;

use Vees\Core\SharedKernel\Application\Contracts\UnitOfWork;
use Vees\Core\Session\Application\Commands\CreateSessionCommand;
use Vees\Core\Session\Domain\Aggregates\Session\SessionFactory;
use Vees\Core\Session\Domain\Contracts\SessionRepository;
use Vees\Core\Session\Domain\ValueObjects\SessionId;
use Vees\Core\SharedKernel\Application\Contracts\Command;
use Vees\Core\SharedKernel\Application\Contracts\CommandHandler;
use Vees\Core\SharedKernel\Contracts\UuidGenerator;

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
