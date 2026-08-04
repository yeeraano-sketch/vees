<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Contracts;

interface Validatable
{
    /** @return array<string, string[]> */
    public function validate(): array;
}
