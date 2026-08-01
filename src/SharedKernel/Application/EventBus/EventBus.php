<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\EventBus;

use App\SharedKernel\Application\Events\DomainEvent;

interface EventBus
{
    public function dispatch(
        DomainEvent $event,
    ): void;
}
