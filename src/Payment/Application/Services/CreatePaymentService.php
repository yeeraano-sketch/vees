<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Application\Services;

use Vees\Core\Payment\Application\Commands\CreatePaymentCommand;
use Vees\Core\SharedKernel\Application\Bus\TransactionalCommandBus;

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
