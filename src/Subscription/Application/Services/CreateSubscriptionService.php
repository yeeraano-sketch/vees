<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Application\Services;

use Vees\Core\SharedKernel\Application\Bus\TransactionalCommandBus;
use Vees\Core\Subscription\Application\Commands\CreateSubscriptionCommand;

final readonly class CreateSubscriptionService
{
    public function __construct(
        private TransactionalCommandBus $bus,
    ) {}

    public function create(
        CreateSubscriptionCommand $command,
    ): mixed {

        return $this->bus->dispatch($command);
    }
}
