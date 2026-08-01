<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain;

enum ErrorType: string
{
    case Business = 'business';
    case System = 'system';
}