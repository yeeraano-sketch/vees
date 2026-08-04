<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Bus;

use Vees\Core\SharedKernel\Application\Contracts\UnitOfWork;
use Vees\Core\SharedKernel\Application\Contracts\Command;
use Vees\Core\SharedKernel\Application\Dispatcher\EventDispatcher;
use Vees\Core\SharedKernel\Application\Transactions\AggregateCollector;

final readonly class TransactionalCommandBus implements CommandBusInterface
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
