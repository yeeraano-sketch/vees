<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Subscribers;

use App\SharedKernel\Application\Events\DomainEvent;

interface EventSubscriber
{
    /**
     * اسم الـ Event الذي يشترك فيه.
     */
    public static function subscribeTo(): string;

    /**
     * تنفيذ الحدث.
     */
    public function handle(
        DomainEvent $event,
    ): void;
}
