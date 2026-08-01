<?php

declare(strict_types=1);

namespace App\Matching\Application\Services;

use App\Matching\Application\Commands\CreateMatchingCommand;
use App\SharedKernel\Application\Bus\CommandBus;

final readonly class CreateMatchingService
{
    public function __construct(
        private CommandBus $bus,
    ) {
    }

    public function create(
        CreateMatchingCommand $command,
    ): mixed {

        return $this->bus->dispatch($command);
    }
}
