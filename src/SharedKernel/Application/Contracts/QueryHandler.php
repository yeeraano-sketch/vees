<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Contracts;

interface QueryHandler
{
    public function handle(Query $query): mixed;
}
