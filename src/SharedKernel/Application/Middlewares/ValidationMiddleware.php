<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Middlewares;

use App\SharedKernel\Application\Contracts\Middleware;

final class ValidationMiddleware implements Middleware
{
    public function process(
        mixed $message,
        callable $next,
    ): mixed {

        return $next($message);
    }
}
