<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\Persistence\Eloquent\Repositories;

use App\Session\Domain\Aggregates\Session\Session;
use App\Session\Domain\Contracts\SessionRepository;
use App\Session\Domain\ValueObjects\SessionId;
use App\Session\Infrastructure\Persistence\Eloquent\Assemblers\SessionPersistenceAssembler;
use App\Session\Infrastructure\Persistence\Eloquent\Models\SessionModel;
use App\SharedKernel\Application\Transactions\AggregateCollector;

final readonly class EloquentSessionRepository implements SessionRepository
{
    public function __construct(
        private SessionPersistenceAssembler $assembler,
        private AggregateCollector $collector,
    ) {
    }

    public function save(
        Session $session,
    ): void {

        $this->assembler->persist($session);

        $this->collector->add($session);
    }

    public function findById(
        SessionId $id,
    ): ?Session {

        // سيتم تنفيذ Hydration في مرحلة لاحقة.
        return null;
    }

    public function exists(
        SessionId $id,
    ): bool {

        return SessionModel::query()
            ->whereKey((string) $id)
            ->exists();
    }

    public function delete(
        Session $session,
    ): void {

        SessionModel::query()
            ->whereKey((string) $session->id())
            ->delete();
    }
}
