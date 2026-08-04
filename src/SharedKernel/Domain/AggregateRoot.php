<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain;

use Vees\Core\SharedKernel\Domain\Traits\RecordsEvents;

abstract class AggregateRoot extends Entity
{
    use RecordsEvents;
}
