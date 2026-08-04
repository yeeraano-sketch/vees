<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Middlewares;

use Vees\Core\SharedKernel\Application\Contracts\Middleware;

final class TransactionMiddleware implements Middleware
{
    public function process(
        mixed $message,
        callable $next,
    ): mixed {

        return $next($message);
    }
}
