<?php

declare(strict_types=1);

namespace App\Matching\Infrastructure\Persistence\Eloquent\Repositories;

use App\Matching\Domain\Aggregates\Matching\Matching;
use App\Matching\Domain\Contracts\MatchingRepository;
use App\Matching\Domain\ValueObjects\MatchingId;
use App\Matching\Infrastructure\Persistence\Eloquent\Assemblers\MatchingPersistenceAssembler;
use App\Matching\Infrastructure\Persistence\Eloquent\Models\MatchingModel;
use App\SharedKernel\Application\Transactions\AggregateCollector;

final readonly class EloquentMatchingRepository implements MatchingRepository
{
    public function __construct(
        private MatchingPersistenceAssembler $assembler,
        private AggregateCollector $collector,
    ) {
    }

    public function save(
        Matching $matching,
    ): void {

        $this->assembler->persist($matching);

        $this->collector->add($matching);
    }

    public function findById(
        MatchingId $id,
    ): ?Matching {

        // سيتم تنفيذ Hydration في Milestone لاحق.
        return null;
    }

    public function exists(
        MatchingId $id,
    ): bool {

        return MatchingModel::query()
            ->whereKey((string) $id)
            ->exists();
    }

    public function delete(
        Matching $matching,
    ): void {

        MatchingModel::query()
            ->whereKey((string) $matching->id())
            ->delete();
    }
}
