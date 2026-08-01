<?php

declare(strict_types=1);

namespace App\Provider\Domain\ValueObjects;

use App\SharedKernel\Domain\ValueObject;

final readonly class City extends ValueObject
{
    public function __construct(
        private string $value,
    ) {
        if (trim($value) === '') {
            throw new \InvalidArgumentException('City cannot be empty.');
        }
    }

    public function value(): string
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
