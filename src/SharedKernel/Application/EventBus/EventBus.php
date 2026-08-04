<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\EventBus;

use Vees\Core\SharedKernel\Domain\DomainEvent;

interface EventBus
{
    public function dispatch(
        DomainEvent $event,
    ): void;
}
