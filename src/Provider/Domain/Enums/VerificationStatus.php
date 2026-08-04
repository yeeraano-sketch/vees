<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Enums;

enum VerificationStatus: string
{
    case Pending = 'pending';

    case Verified = 'verified';

    case Rejected = 'rejected';
}
