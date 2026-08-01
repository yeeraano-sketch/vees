<?php

declare(strict_types=1);

namespace App\Provider\Application\Commands;

use App\SharedKernel\Application\Contracts\Command;

final readonly class ChangeWorkModeCommand implements Command
{
    public function __construct(
        public string $providerId,
        public string $workMode,
    ) {
    }
}
