<?php

declare(strict_types=1);

namespace App\Matching\Application\Handlers;

use App\SharedKernel\Application\Contracts\UnitOfWork;
use App\Matching\Application\Commands\CreateMatchingCommand;
use App\Matching\Domain\Aggregates\Matching\MatchingFactory;
use App\Matching\Domain\Contracts\MatchingRepository;
use App\Matching\Domain\ValueObjects\MatchingId;
use App\SharedKernel\Application\Contracts\Command;
use App\SharedKernel\Application\Contracts\CommandHandler;
use App\SharedKernel\Contracts\UuidGenerator;

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
