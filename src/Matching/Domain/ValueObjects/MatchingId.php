<?php

declare(strict_types=1);

namespace App\Matching\Domain\ValueObjects;

use App\SharedKernel\Domain\ValueObject;

final readonly class MatchingId extends ValueObject
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function fromString(
        string $value,
    ): self {

        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
