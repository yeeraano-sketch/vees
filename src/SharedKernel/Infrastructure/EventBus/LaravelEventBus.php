<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\EventBus;

use App\SharedKernel\Contracts\EventBus;
use App\SharedKernel\Domain\DomainEvent;
use Illuminate\Contracts\Events\Dispatcher;

final readonly class LaravelEventBus implements EventBus
{
    public function __construct(
        private Dispatcher $dispatcher,
    ) {
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}