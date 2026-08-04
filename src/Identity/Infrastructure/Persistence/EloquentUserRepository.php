<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Infrastructure\Persistence;

use Vees\Core\Identity\Domain\Aggregates\User;
use Vees\Core\Identity\Domain\Repositories\UserRepository;
use Vees\Core\Identity\Domain\ValueObjects\Email;
use Vees\Core\Identity\Domain\ValueObjects\UserId;

final readonly class EloquentUserRepository implements UserRepository
{
    public function save(User $user): void
    {
        // TODO: Map Aggregate -> Eloquent Model
    }

    public function findById(UserId $id): ?User
    {
        // TODO: Map Eloquent Model -> Aggregate
        return null;
    }

    public function findByEmail(Email $email): ?User
    {
        // TODO: Map Eloquent Model -> Aggregate
        return null;
    }

    public function existsByEmail(Email $email): bool
    {
        // TODO: Query database
        return false;
    }
}
