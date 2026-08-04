<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Application\Handlers;

use Vees\Core\Matching\Application\Commands\DispatchSessionCommand;
use Vees\Core\Matching\Application\Services\DispatchEngine;
use Vees\Core\SharedKernel\Application\Contracts\CommandHandler;

final readonly class DispatchSessionHandler implements CommandHandler
{
    public function __construct(
        private DispatchEngine $engine,
    ) {}

    public function handle(DispatchSessionCommand $command): string
    {
        return $this->engine->dispatch($command);
    }
}
