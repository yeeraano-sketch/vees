<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Domain\ValueObjects;

use Vees\Core\SharedKernel\Domain\ValueObject;

final readonly class NotificationId extends ValueObject
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
