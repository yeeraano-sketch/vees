<?php

declare(strict_types=1);

namespace App\Session\Application\Queries;

use App\Framework\Application\Queries\Query;

final readonly class GetSessionByIdQuery implements Query
{
    public function __construct(
        public string $sessionId,
    ) {
    }
}
