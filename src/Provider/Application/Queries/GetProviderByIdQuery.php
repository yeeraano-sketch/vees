<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Application\Queries;

use Vees\Core\Framework\Application\Queries\Query;

final readonly class GetProviderByIdQuery implements Query
{
    public function __construct(
        public string $providerId,
    ) {}
}
