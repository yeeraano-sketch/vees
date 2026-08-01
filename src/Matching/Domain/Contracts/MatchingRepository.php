<?php

declare(strict_types=1);

namespace App\Matching\Domain\Contracts;

use App\Matching\Domain\Aggregates\Matching\Matching;
use App\Matching\Domain\ValueObjects\MatchingId;

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
