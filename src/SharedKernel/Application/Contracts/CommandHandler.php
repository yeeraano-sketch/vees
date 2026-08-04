<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Contracts;

interface CommandHandler
{
    public function handle(Command $command): mixed;
}
