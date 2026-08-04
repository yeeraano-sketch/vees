<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain;

abstract readonly class ValueObject
{
    final public function equals(self $other): bool
    {
        return $this->toArray() == $other->toArray();
    }

    /**
     * @return array<string, mixed>
     */
    abstract public function toArray(): array;
}