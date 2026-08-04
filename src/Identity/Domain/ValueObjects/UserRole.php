<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Domain\ValueObjects;

enum UserRole: string
{
    case Customer = 'customer';
    case Provider = 'provider';
    case Admin = 'admin';

    public function isCustomer(): bool
    {
        return $this === self::Customer;
    }

    public function isProvider(): bool
    {
        return $this === self::Provider;
    }

    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }
}
