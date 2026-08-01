<?php

declare(strict_types=1);

namespace App\Matching\Domain\Exceptions;

use DomainException;

final class NoEligibleProviderFound extends DomainException
{
}
