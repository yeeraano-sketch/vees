<?php

declare(strict_types=1);

namespace App\Matching\Application\Queries;

use App\Framework\Application\Queries\Query;

final readonly class GetMatchingByIdQuery implements Query
{
    public function __construct(
        public string $matchingId,
    ) {
    }
}
