<?php

declare(strict_types=1);

namespace App\Provider\Domain\ValueObjects;

enum Availability: string
{
    case Offline = 'offline';
    case Available = 'available';
    case Busy = 'busy';
}
