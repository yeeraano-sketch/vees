<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Domain\Aggregates\Matching;

use Vees\Core\Matching\Domain\ValueObjects\MatchingId;

final readonly class MatchingFactory
{
    public function create(
        MatchingId $id,
        string $sessionId,
    ): Matching {

        return Matching::create(
            id: $id,
            sessionId: $sessionId,
        );
    }
}
