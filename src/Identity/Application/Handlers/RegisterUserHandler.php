<?php

declare(strict_types=1);

namespace App\Identity\Application\Handlers;

use App\Identity\Application\Commands\RegisterUserCommand;
use App\Identity\Domain\Aggregates\User;
use App\Identity\Domain\Repositories\UserRepository;
use App\Identity\Domain\ValueObjects\Email;
use App\Identity\Domain\ValueObjects\PasswordHash;
use App\Identity\Domain\ValueObjects\UserId;

final readonly class RegisterUserHandler
{
    public function __construct(
        private UserRepository $users,
    ) {
    }

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
