<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Middlewares;

use Vees\Core\SharedKernel\Application\Contracts\Middleware;
use Vees\Core\SharedKernel\Application\Dispatcher\EventDispatcher;
use Vees\Core\SharedKernel\Domain\AggregateRoot;

final readonly class EventDispatchMiddleware implements Middleware
{
    public function __construct(
        private EventDispatcher $dispatcher,
    ) {
    }

    public function process(
        mixed $message,
        callable $next,
    ): mixed {
        $result = $next($message);

        if ($result instanceof AggregateRoot) {
            $this->dispatcher->dispatchFrom($result);
        }

        return $result;
    }
}
