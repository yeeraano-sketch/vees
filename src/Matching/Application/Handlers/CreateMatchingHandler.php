<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Application\Handlers;

use Vees\Core\SharedKernel\Application\Contracts\UnitOfWork;
use Vees\Core\Matching\Application\Commands\CreateMatchingCommand;
use Vees\Core\Matching\Domain\Aggregates\Matching\MatchingFactory;
use Vees\Core\Matching\Domain\Contracts\MatchingRepository;
use Vees\Core\Matching\Domain\ValueObjects\MatchingId;
use Vees\Core\SharedKernel\Application\Contracts\Command;
use Vees\Core\SharedKernel\Application\Contracts\CommandHandler;
use Vees\Core\SharedKernel\Contracts\UuidGenerator;

final readonly class CreateMatchingHandler implements CommandHandler
{
    public function __construct(
        private MatchingFactory $factory,
        private MatchingRepository $repository,
        private UnitOfWork $unitOfWork,
        private UuidGenerator $uuid,
    ) {
    }

    public function handle(
        Command $command,
    ): mixed {

        /** @var CreateMatchingCommand $command */

        $matching = $this->factory->create(

            id: MatchingId::fromString(
                $this->uuid->generate()
            ),

            sessionId: $command->sessionId,
        );

        $this->repository->save($matching);

        $this->unitOfWork->commit();

        return $matching;
    }
}
