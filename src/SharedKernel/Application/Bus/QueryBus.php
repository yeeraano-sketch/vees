<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Bus;

use App\SharedKernel\Application\Contracts\Query;

interface QueryBus
{
    public function ask(
        Query $query,
    ): mixed;
}
