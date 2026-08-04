<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Application\Services;

use Vees\Core\Matching\Application\Commands\CreateMatchingCommand;
use Vees\Core\SharedKernel\Application\Bus\TransactionalCommandBus;

final readonly class CreateMatchingService
{
    public function __construct(
        private TransactionalCommandBus $bus,
    ) {
    }

    public function create(
        CreateMatchingCommand $command,
    ): mixed {

        return $this->bus->dispatch($command);
    }
}
