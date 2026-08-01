<?php

declare(strict_types=1);

namespace App\Identity\Domain\Aggregates;

use App\Identity\Domain\Events\UserActivated;
use App\Identity\Domain\Events\UserDeactivated;
use App\Identity\Domain\Events\UserRegistered;
use App\Identity\Domain\ValueObjects\Email;
use App\Identity\Domain\ValueObjects\PasswordHash;
use App\Identity\Domain\ValueObjects\UserId;
use App\Identity\Domain\ValueObjects\UserRole;
use App\SharedKernel\Domain\AggregateRoot;

final class User extends AggregateRoot
{
    private bool $active = false;

    private function __construct(
        private readonly UserId $id,
        private Email $email,
        private PasswordHash $passwordHash,
        private UserRole $role,
    ) {
    }

    public static function register(
        UserId $id,
        Email $email,
        PasswordHash $passwordHash,
        UserRole $role,
    ): self {
        $user = new self(
            $id,
            $email,
            $passwordHash,
            $role,
        );

        $user->record(
            new UserRegistered(
                $id->toString(),
                $email->toString(),
                $role->value,
            )
        );

        return $user;
    }

    public function activate(): void
    {
        if ($this->active) {
            return;
        }

        $this->active = true;

        $this->record(
            new UserActivated(
                $this->id->toString(),
            )
        );
    }

    public function deactivate(): void
    {
        if (! $this->active) {
            return;
        }

        $this->active = false;

        $this->record(
            new UserDeactivated(
                $this->id->toString(),
            )
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function passwordHash(): PasswordHash
    {
        return $this->passwordHash;
    }

    public function role(): UserRole
    {
        return $this->role;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
