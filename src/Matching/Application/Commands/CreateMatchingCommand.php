<?php

declare(strict_types=1);

namespace App\Matching\Application\Commands;

use App\Framework\Application\Commands\Command;

final readonly class CreateMatchingCommand implements Command
{
    public function __construct(
        public string $sessionId,
    ) {
    }
}
