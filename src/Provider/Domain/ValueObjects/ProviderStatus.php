<?php

declare(strict_types=1);

namespace App\Provider\Domain\ValueObjects;

enum ProviderStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Suspended = 'suspended';
    case Blocked = 'blocked';
}
