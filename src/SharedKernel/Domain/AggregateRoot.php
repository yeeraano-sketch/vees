<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain;

use App\SharedKernel\Domain\Traits\RecordsEvents;

abstract class AggregateRoot extends Entity
{
    use RecordsEvents;
}
