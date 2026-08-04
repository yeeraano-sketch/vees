<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Application\Handlers;

use Vees\Core\Provider\Application\Commands\ChangeWorkModeCommand;
use Vees\Core\SharedKernel\Application\Contracts\CommandHandler;

final readonly class ChangeWorkModeHandler implements CommandHandler
{
    public function handle(
        ChangeWorkModeCommand $command,
    ): void {

        throw new \LogicException(
            'ChangeWorkModeHandler is not implemented yet.'
        );
    }
}
