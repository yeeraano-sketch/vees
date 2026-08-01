<?php

declare(strict_types=1);

namespace App\Provider\Application\Handlers;

use App\Provider\Application\Commands\ChangeWorkModeCommand;
use App\SharedKernel\Application\Contracts\CommandHandler;

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
