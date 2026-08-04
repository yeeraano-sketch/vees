<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Domain\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';

    case Paid = 'paid';

    case Failed = 'failed';

    case Refunded = 'refunded';

    case Cancelled = 'cancelled';
}
