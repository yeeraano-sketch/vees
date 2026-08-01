<?php

declare(strict_types=1);

namespace App\SharedKernel\Contracts;

interface UuidGenerator
{
    public function generate(): string;
}