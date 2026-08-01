<?php

declare(strict_types=1);

namespace App\Framework\Application\Handlers;

use App\Framework\Application\Queries\Query;

interface QueryHandler
{
    public function handle(Query $query): mixed;
}
