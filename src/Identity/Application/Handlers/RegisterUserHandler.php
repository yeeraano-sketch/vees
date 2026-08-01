<?php

declare(strict_types=1);

namespace App\Identity\Application\CommandHandlers;

use App\Identity\Application\Commands\RegisterUserCommand;
use App\Identity\Domain\Aggregates\User;
use App\Identity\Domain\Repositories\UserRepository;
use App\Identity\Domain\ValueObjects\Email;
use App\Identity\Domain\ValueObjects\PasswordHash;
use App\Identity\Domain\ValueObjects\UserId;
use App\SharedKernel\Contracts\EventBus;

final readonly class RegisterUserHandler
{
    public function __construct(
        private UserRepository $users,
        private EventBus $eventBus,
    ) {
    }

    public function __invoke(RegisterUserCommand $command): User
    {
        $user = User::register(
            new UserId($command->id),
            new Email($command->email),
            new PasswordHash($command->passwordHash),
            $command->role,
        );

        $this->users->save($user);

        foreach ($user->releaseEvents() as $event) {
            $this->eventBus->publish($event);
        }

        return $user;
    }
}
