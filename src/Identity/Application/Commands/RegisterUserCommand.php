<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Application\Commands;

use Vees\Core\Identity\Domain\ValueObjects\UserRole;

final readonly class RegisterUserCommand
{
    public function __construct(
        public string $id,
        public string $email,
        public string $passwordHash,
        public UserRole $role,
    ) {}
}
