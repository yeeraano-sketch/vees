<?php

declare(strict_types=1);

namespace App\Matching\Domain\Enums;

enum MatchingStatus: string
{
    case Pending = 'pending';

    case Matched = 'matched';

    case Rejected = 'rejected';

    case Cancelled = 'cancelled';
}
