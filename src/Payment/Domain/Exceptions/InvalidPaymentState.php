<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Domain\Exceptions;

use Vees\Core\SharedKernel\Domain\Exceptions\DomainException;

final class InvalidPaymentState extends DomainException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'Invalid payment state transition.');
    }
}
