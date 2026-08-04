<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\EventBus;

use Vees\Core\SharedKernel\Domain\DomainEvent;
use Vees\Core\SharedKernel\Infrastructure\Jobs\DispatchEventJob;

final readonly class AsyncEventBus implements EventBus
{
    public function dispatch(DomainEvent $event): void
    {
        DispatchEventJob::dispatch($event);
    }
}
