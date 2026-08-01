<?php

declare(strict_types=1);

namespace App\SharedKernel\Contracts;

use App\SharedKernel\Domain\DomainEvent;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}