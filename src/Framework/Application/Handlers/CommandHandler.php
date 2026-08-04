<?php

declare(strict_types=1);

namespace Vees\Core\Framework\Application\Handlers;

use Vees\Core\Framework\Application\Commands\Command;
use Vees\Core\SharedKernel\Domain\Result;

interface CommandHandler
{
    public function handle(Command $command): Result;
}
