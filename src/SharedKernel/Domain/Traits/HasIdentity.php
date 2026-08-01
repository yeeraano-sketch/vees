<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Traits;

trait HasIdentity
{
    abstract protected function identity(): mixed;

    final public function equals(object $other): bool
    {
        return $other instanceof static
            && $this->identity() === $other->identity();
    }
}
