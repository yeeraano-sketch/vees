<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Bus;

use Vees\Core\SharedKernel\Application\Contracts\Query;
use Vees\Core\SharedKernel\Application\Resolver\HandlerResolver;

final readonly class SynchronousQueryBus implements QueryBus
{
    public function __construct(
        private HandlerResolver $resolver,
    ) {
    }

    public function ask(
        Query $query,
    ): mixed {
        return $this
            ->resolver
            ->resolve($query)
            ->handle($query);
    }
}
