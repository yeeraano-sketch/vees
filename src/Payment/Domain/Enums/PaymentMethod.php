<?php

declare(strict_types=1);

namespace App\Payment\Domain\Enums;

enum PaymentMethod: string
{
    case Card = 'card';

    case ApplePay = 'apple_pay';

    case STCPay = 'stc_pay';

    case Mada = 'mada';
}
