<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Domain\ValueObjects;

use Vees\Core\Identity\Domain\Exceptions\InvalidEmail;
use Vees\Core\SharedKernel\Domain\ValueObject;

final readonly class Email extends ValueObject
{
    public function __construct(
        private string $value,
    ) {
        $email = trim(strtolower($value));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmail::fromValue($value);
        }

        $this->value = $email;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
        ];
    }
}