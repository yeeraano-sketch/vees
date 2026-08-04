<?php

declare(strict_types=1);

namespace Vees\Core\Session\Application\Commands;

use Vees\Core\SharedKernel\Application\Contracts\Command;

final readonly class AcceptSessionCommand implements Command
{
    public function __construct(
        public string $sessionId,
    ) {}
}
