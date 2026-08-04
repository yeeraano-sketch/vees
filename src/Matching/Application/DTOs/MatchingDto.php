<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Application\DTOs;

final readonly class MatchingDto
{
    public function __construct(
        public string $id,
        public string $sessionId,
        public ?string $providerId,
        public string $status,
    ) {}
}
