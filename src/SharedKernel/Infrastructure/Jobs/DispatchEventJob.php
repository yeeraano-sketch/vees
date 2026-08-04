<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Infrastructure\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vees\Core\SharedKernel\Application\Subscribers\SubscriberRegistry;
use Vees\Core\SharedKernel\Domain\DomainEvent;

final class DispatchEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private DomainEvent $event,
    ) {}

    public function handle(SubscriberRegistry $registry): void
    {
        foreach ($registry->subscribersFor($this->event::class) as $subscriber) {
            $subscriber->handle($this->event);
        }
    }
}
