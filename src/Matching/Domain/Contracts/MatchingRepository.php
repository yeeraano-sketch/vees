<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Domain\Contracts;

use Vees\Core\Matching\Domain\Aggregates\Matching\Matching;
use Vees\Core\Matching\Domain\ValueObjects\MatchingId;

interface MatchingRepository
{
    public function save(
        Matching $matching,
    ): void;

    public function findById(
        MatchingId $id,
    ): ?Matching;

    public function exists(
        MatchingId $id,
    ): bool;

    public function delete(
        Matching $matching,
    ): void;
}
