<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Application\Handlers;

use Vees\Core\Identity\Application\Commands\RegisterUserCommand;
use Vees\Core\Identity\Domain\Aggregates\User;
use Vees\Core\Identity\Domain\Repositories\UserRepository;
use Vees\Core\Identity\Domain\ValueObjects\Email;
use Vees\Core\Identity\Domain\ValueObjects\PasswordHash;
use Vees\Core\Identity\Domain\ValueObjects\UserId;

final readonly class RegisterUserHandler
{
    public function __construct(
        private UserRepository $users,
    ) {}

    public function handle(RegisterUserCommand $command): User
    {
        $user = User::register(
            new UserId($command->id),
            new Email($command->email),
            new PasswordHash($command->passwordHash),
            $command->role,
        );

        $this->users->save($user);

        return $user;
    }
}
