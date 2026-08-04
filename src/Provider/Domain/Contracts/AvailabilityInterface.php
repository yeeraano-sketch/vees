<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Contracts;

use Vees\Core\Provider\Domain\Enums\AvailabilityStatus;

interface AvailabilityInterface
{
    public function status(): AvailabilityStatus;
}
