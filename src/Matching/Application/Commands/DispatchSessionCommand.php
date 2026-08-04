<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Application\Commands;

use Vees\Core\SharedKernel\Application\Contracts\Command;

final readonly class DispatchSessionCommand implements Command
{
    public function __construct(
        public string $sessionId,
        public int $serviceType,
        public string $cityId,
    ) {}
}
