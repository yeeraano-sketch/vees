<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Contracts;

interface QueryHandler
{
    public function handle(Query $query): mixed;
}
