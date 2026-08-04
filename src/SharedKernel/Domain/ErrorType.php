<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain;

enum ErrorType: string
{
    case Business = 'business';
    case System = 'system';
}
