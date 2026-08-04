<?php

declare(strict_types=1);

namespace Vees\Core\Session\Application\Queries;

use Vees\Core\Framework\Application\Queries\Query;

final readonly class GetSessionByIdQuery implements Query
{
    public function __construct(
        public string $sessionId,
    ) {}
}
