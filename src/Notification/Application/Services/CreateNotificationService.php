<?php

declare(strict_types=1);

namespace App\Notification\Application\Services;

use App\Notification\Application\Commands\CreateNotificationCommand;
use App\SharedKernel\Application\Bus\CommandBus;

final readonly class CreateNotificationService
{
    public function __construct(
        private CommandBus $bus,
    ) {
    }

    public function create(
        CreateNotificationCommand $command,
    ): mixed {

        return $this->bus->dispatch($command);
    }
}
