<?php

declare(strict_types=1);

namespace App\Session\Domain\Contracts;

use App\Session\Domain\Aggregates\Session\Session;
use App\Session\Domain\ValueObjects\SessionId;

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
