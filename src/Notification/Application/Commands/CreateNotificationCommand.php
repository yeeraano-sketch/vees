<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Application\Commands;

use Vees\Core\SharedKernel\Application\Contracts\Command;

final readonly class CreateNotificationCommand implements Command
{
    public function __construct(
        public string $recipientId,
        public string $title,
        public string $message,
    ) {
    }
}
