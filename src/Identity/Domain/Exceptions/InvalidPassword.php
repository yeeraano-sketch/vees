<?php

declare(strict_types=1);

namespace App\Identity\Domain\Exceptions;

use DomainException;

final class InvalidPassword extends DomainException
{
    public static function empty(): self
    {
        return new self('Password hash cannot be empty.');
    }

    public static function notHashed(): self
    {
        return new self('Password must already be hashed.');
    }
}