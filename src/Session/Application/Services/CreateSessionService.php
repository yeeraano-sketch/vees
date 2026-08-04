<?php

declare(strict_types=1);

namespace Vees\Core\Session\Application\Services;

use Vees\Core\Session\Application\Commands\CreateSessionCommand;
use Vees\Core\SharedKernel\Application\Bus\TransactionalCommandBus;

final readonly class CreateSessionService
{
    public function __construct(
        private TransactionalCommandBus $bus,
    ) {}

    public function create(
        CreateSessionCommand $command,
    ): mixed {

        return $this->bus->dispatch($command);
    }
}
