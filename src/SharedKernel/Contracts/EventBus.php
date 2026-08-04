<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Contracts;

use Vees\Core\SharedKernel\Domain\DomainEvent;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}
