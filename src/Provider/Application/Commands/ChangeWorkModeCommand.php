<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Application\Commands;

use Vees\Core\SharedKernel\Application\Contracts\Command;

final readonly class ChangeWorkModeCommand implements Command
{
    public function __construct(
        public string $providerId,
        public string $workMode,
    ) {}
}
