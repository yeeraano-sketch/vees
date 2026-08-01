<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Contracts;

interface Middleware
{
    public function process(
        mixed $message,
        callable $next,
    ): mixed;
}
