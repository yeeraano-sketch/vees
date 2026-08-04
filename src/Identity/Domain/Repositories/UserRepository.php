<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Domain\Repositories;

use Vees\Core\Identity\Domain\Aggregates\User;
use Vees\Core\Identity\Domain\ValueObjects\Email;
use Vees\Core\Identity\Domain\ValueObjects\UserId;

interface UserRepository
{
    public function save(User $user): void;

    public function findById(UserId $id): ?User;

    public function findByEmail(Email $email): ?User;

    public function existsByEmail(Email $email): bool;
}
