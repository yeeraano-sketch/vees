<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Domain\Enums;

enum PaymentMethod: string
{
    case Card = 'card';

    case ApplePay = 'apple_pay';

    case STCPay = 'stc_pay';

    case Mada = 'mada';
}
