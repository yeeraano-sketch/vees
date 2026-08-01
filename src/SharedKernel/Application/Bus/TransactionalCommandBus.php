<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Bus;

use App\SharedKernel\Application\Contracts\UnitOfWork;
use App\SharedKernel\Application\Contracts\Command;
use App\SharedKernel\Application\Dispatcher\EventDispatcher;
use App\SharedKernel\Application\Transactions\AggregateCollector;

final readonly class TransactionalCommandBus
{
    public function __construct(
        private CommandBus $commandBus,
        private UnitOfWork $unitOfWork,
        private AggregateCollector $collector,
        private EventDispatcher $dispatcher,
    ) {
    }

    public function dispatch(
        Command $command,
    ): mixed {

        $this->unitOfWork->begin();

        try {

            $result = $this->commandBus->dispatch($command);

            $this->unitOfWork->commit();

            $this->dispatcher->dispatchAll(
                $this->collector->all()
            );

            $this->collector->clear();

            return $result;

        } catch (\Throwable $exception) {

            $this->collector->clear();

            $this->unitOfWork->rollback();

            throw $exception;
        }
    }
}
