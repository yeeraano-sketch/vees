<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Contracts;

interface CommandHandler
{
    public function handle(Command $command): mixed;
}
