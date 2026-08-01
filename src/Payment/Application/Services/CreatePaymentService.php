<?php

declare(strict_types=1);

namespace App\Payment\Application\Services;

use App\Payment\Application\Commands\CreatePaymentCommand;
use App\SharedKernel\Application\Bus\TransactionalCommandBus;

final readonly class CreatePaymentService
{
    public function __construct(
        private TransactionalCommandBus $bus,
    ) {
    }

    public function create(
        CreatePaymentCommand $command,
    ): mixed {

        return $this->bus->dispatch($command);
    }
}
