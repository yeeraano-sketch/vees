<?php

declare(strict_types=1);

namespace App\Provider\Application\Queries;

use App\Framework\Application\Queries\Query;

final readonly class GetProviderByIdQuery implements Query
{
    public function __construct(
        public string $providerId,
    ) {
    }
}