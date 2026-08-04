<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain;

use Vees\Core\SharedKernel\Domain\Traits\HasIdentity;

abstract class Entity
{
    use HasIdentity;

    abstract protected function identity(): mixed;
}
