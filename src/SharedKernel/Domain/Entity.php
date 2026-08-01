<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain;

use App\SharedKernel\Domain\Traits\HasIdentity;

abstract class Entity
{
    use HasIdentity;

    abstract protected function identity(): mixed;
}
