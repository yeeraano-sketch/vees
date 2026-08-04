<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Bus;

use Vees\Core\SharedKernel\Application\Contracts\Query;

interface QueryBus
{
    public function ask(
        Query $query,
    ): mixed;
}
