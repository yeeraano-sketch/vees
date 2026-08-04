<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Bus;

use Vees\Core\SharedKernel\Application\Contracts\Command;

interface CommandBusInterface
{
    public function dispatch(Command $command): mixed;
}
