<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Domain\ValueObjects;

use Vees\Core\SharedKernel\Domain\ValueObject;

final readonly class UserId extends ValueObject
{
    public function __construct(
        private string $value,
    ) {
        if ($value === '') {
            throw new \InvalidArgumentException('UserId cannot be empty.');
        }
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