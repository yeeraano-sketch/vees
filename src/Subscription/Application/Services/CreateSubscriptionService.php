<?php

declare(strict_types=1);

namespace App\Subscription\Application\Services;

use App\SharedKernel\Application\Bus\TransactionalCommandBus;
use App\Subscription\Application\Commands\CreateSubscriptionCommand;

final readonly class CreateSubscriptionService
{
    public function __construct(
        private TransactionalCommandBus $bus,
    ) {
    }

    public function create(
        CreateSubscriptionCommand $command,
    ): mixed {

        return $this->bus->dispatch($command);
    }
}
