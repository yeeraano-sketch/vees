<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Enums;

enum ProviderStatus: string
{
    case Pending = 'pending';

    case Active = 'active';

    case Suspended = 'suspended';

    case Deactivated = 'deactivated';
}
