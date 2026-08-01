<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain;

abstract class Entity
{
    /**
     * Returns the unique identity of the entity.
     */
    abstract protected function identity(): mixed;

    final public function equals(self $other): bool
    {
        return $this->identity() === $other->identity();
    }
}
