<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Domain\ValueObjects;

use Vees\Core\SharedKernel\Domain\ValueObject;
use InvalidArgumentException;

final readonly class PasswordHash extends ValueObject
{
    private string $value;

    public function __construct(string $hashedValue)
    {
        if (empty($hashedValue)) {
            throw new InvalidArgumentException('Password hash cannot be empty.');
        }
        $this->value = $hashedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return ['hash' => $this->value];
    }
}
