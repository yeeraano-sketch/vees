<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Application\Queries;

use Vees\Core\Framework\Application\Queries\Query;

final readonly class GetMatchingByIdQuery implements Query
{
    public function __construct(
        public string $matchingId,
    ) {
    }
}
