<?php

declare(strict_types=1);

namespace App\Framework\Application\Handlers;

use App\Framework\Application\Commands\Command;
use App\SharedKernel\Domain\Result;

interface CommandHandler
{
    public function handle(Command $command): Result;
}
