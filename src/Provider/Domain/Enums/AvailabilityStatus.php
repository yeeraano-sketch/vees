<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Enums;

enum AvailabilityStatus: string
{
    case Offline = 'offline';

    case Available = 'available';

    case Busy = 'busy';
}
