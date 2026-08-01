<?php

declare(strict_types=1);

namespace App\Provider\Application\Commands;

use App\SharedKernel\Application\Contracts\Command;

final readonly class RegisterProviderCommand implements Command
{
    public function __construct(
        public string $fullName,
        public string $phoneNumber,
        public string $city,
        public string $workMode,
    ) {
    }
}