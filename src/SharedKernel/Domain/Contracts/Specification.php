<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain\Contracts;

interface Specification
{
    public function isSatisfiedBy(mixed $candidate): bool;
}
