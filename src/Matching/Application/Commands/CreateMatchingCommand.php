<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Application\Commands;

use Vees\Core\Framework\Application\Commands\Command;

final readonly class CreateMatchingCommand implements Command
{
    public function __construct(
        public string $sessionId,
    ) {
    }
}
