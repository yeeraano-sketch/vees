<?php

declare(strict_types=1);

namespace App\Session\Application\Services;

use App\Session\Application\Commands\CreateSessionCommand;
use App\SharedKernel\Application\Bus\CommandBus;

final readonly class CreateSessionService
{
    public function __construct(
        private CommandBus $bus,
    ) {
    }

    public function create(
        CreateSessionCommand $command,
    ): mixed {

        return $this->bus->dispatch($command);
    }
}
