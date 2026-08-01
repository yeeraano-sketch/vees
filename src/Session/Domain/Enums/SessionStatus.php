<?php

declare(strict_types=1);

namespace App\Session\Domain\Enums;

enum SessionStatus: string
{
    case Pending = 'pending';

    case Matched = 'matched';

    case Accepted = 'accepted';

    case Started = 'started';

    case Completed = 'completed';

    case Cancelled = 'cancelled';
}
