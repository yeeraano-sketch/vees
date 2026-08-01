<?php

declare(strict_types=1);

namespace App\Identity\Domain\Exceptions;

use DomainException;

final class InvalidEmail extends DomainException
{
    public static function fromValue(string $email): self
    {
        return new self(
            sprintf('"%s" is not a valid email address.', $email)
        );
    }
}