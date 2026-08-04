<?php

declare(strict_types=1);

namespace Vees\Core\Framework\Application\Handlers;

use Vees\Core\Framework\Application\Queries\Query;

interface QueryHandler
{
    public function handle(Query $query): mixed;
}
