<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Middlewares;

use Vees\Core\SharedKernel\Application\Contracts\Middleware;
use Vees\Core\SharedKernel\Application\Contracts\Validatable;
use Vees\Core\SharedKernel\Domain\Exceptions\DomainException;

final class ValidationMiddleware implements Middleware
{
    public function process(
        mixed $message,
        callable $next,
    ): mixed {
        if ($message instanceof Validatable) {
            $errors = $message->validate();
            if (! empty($errors)) {
                throw new DomainException(
                    'Validation failed: '.json_encode($errors)
                );
            }
        }

        return $next($message);
    }
}
