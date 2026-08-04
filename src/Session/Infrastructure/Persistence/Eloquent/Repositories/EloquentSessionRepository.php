<?php

declare(strict_types=1);

namespace Vees\Core\Session\Infrastructure\Persistence\Eloquent\Repositories;

use Vees\Core\Session\Domain\Aggregates\Session\Session;
use Vees\Core\Session\Domain\Contracts\SessionRepository;
use Vees\Core\Session\Domain\ValueObjects\SessionId;
use Vees\Core\Session\Infrastructure\Persistence\Eloquent\Assemblers\SessionPersistenceAssembler;
use Vees\Core\Session\Infrastructure\Persistence\Eloquent\Models\SessionModel;
use Vees\Core\SharedKernel\Application\Transactions\AggregateCollector;

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
