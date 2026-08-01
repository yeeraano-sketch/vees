<?php

declare(strict_types=1);

namespace App\Matching\Domain\Aggregates\Matching;

use App\Matching\Domain\ValueObjects\MatchingId;

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
