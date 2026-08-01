<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain;

use DateTimeImmutable;

interface DomainEvent
{
    /**
     * Unique identifier of this event instance.
     */
    public function eventId(): string;

    /**
     * When the event occurred.
     */
    public function occurredAt(): DateTimeImmutable;

    /**
     * Domain event name.
     *
     * Example:
     * PaymentSucceeded
     * SubscriptionActivated
     */
    public function eventName(): string;

    /**
     * Serializable event payload.
     */
    public function payload(): array;
}