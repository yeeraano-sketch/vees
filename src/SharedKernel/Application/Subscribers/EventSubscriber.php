<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Subscribers;

use Vees\Core\SharedKernel\Domain\DomainEvent;

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
