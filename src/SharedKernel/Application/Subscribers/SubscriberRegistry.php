<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Subscribers;

final class SubscriberRegistry
{
    /**
     * @var array<string,list<EventSubscriber>>
     */
    private array $subscribers = [];

    public function register(
        EventSubscriber $subscriber,
    ): void {

        $this->subscribers[
            $subscriber::subscribeTo()
        ][] = $subscriber;
    }

    /**
     * @return list<EventSubscriber>
     */
    public function subscribersFor(
        string $event,
    ): array {

        return $this->subscribers[$event] ?? [];
    }
}
