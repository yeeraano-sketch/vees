<?php

declare(strict_types=1);

namespace App\SharedKernel\Contracts;

interface CommandBus
{
    public function dispatch(Command $command): mixed;
}