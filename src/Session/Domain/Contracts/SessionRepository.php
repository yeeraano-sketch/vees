<?php

declare(strict_types=1);

namespace Vees\Core\Session\Domain\Contracts;

use Vees\Core\Session\Domain\Aggregates\Session\Session;
use Vees\Core\Session\Domain\ValueObjects\SessionId;

interface SessionRepository
{
    public function save(
        Session $session,
    ): void;

    public function findById(
        SessionId $id,
    ): ?Session;

    public function exists(
        SessionId $id,
    ): bool;

    public function delete(
        Session $session,
    ): void;
}
