<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\ValueObjects;

use Vees\Core\SharedKernel\Domain\ValueObject;

final readonly class FullName extends ValueObject
{
    public function __construct(
        private string $value,
    ) {
        if (trim($value) === '') {
            throw new \InvalidArgumentException('Full name cannot be empty.');
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
