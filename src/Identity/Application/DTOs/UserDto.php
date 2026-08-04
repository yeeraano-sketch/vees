<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Application\DTOs;

use Vees\Core\Identity\Domain\Aggregates\User;

final readonly class UserDto
{
    public function __construct(
        public string $id,
        public string $email,
        public string $role,
        public bool $active,
    ) {}

    public static function fromAggregate(User $user): self
    {
        return new self(
            $user->id()->toString(),
            $user->email()->toString(),
            $user->role()->value,
            $user->isActive(),
        );
    }
}
