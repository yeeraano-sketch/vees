<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Application\Queries;

final readonly class GetUserByIdQuery
{
    public function __construct(
        public string $id,
    ) {}
}
