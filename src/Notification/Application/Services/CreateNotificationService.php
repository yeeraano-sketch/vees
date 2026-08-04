<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Application\Services;

use Vees\Core\Notification\Application\Commands\CreateNotificationCommand;
use Vees\Core\SharedKernel\Application\Bus\CommandBusInterface;

final readonly class CreateNotificationService
{
    public function __construct(
        private CommandBusInterface $bus,
    ) {
    }

    public function create(
        CreateNotificationCommand $command,
    ): mixed {
        return $this->bus->dispatch($command);
    }
}
