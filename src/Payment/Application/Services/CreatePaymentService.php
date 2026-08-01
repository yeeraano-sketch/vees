<?php

declare(strict_types=1);

namespace App\Payment\Application\Services;

use App\Payment\Application\Commands\CreatePaymentCommand;
use App\SharedKernel\Application\Bus\CommandBus;

final readonly class CreatePaymentService
{
    public function __construct(
        private CommandBus $bus,
    ) {
    }

    public function create(
        CreatePaymentCommand $command,
    ): mixed {

        return $this->bus->dispatch($command);
    }
}
