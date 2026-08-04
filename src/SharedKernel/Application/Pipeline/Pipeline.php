<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Pipeline;

use Vees\Core\SharedKernel\Application\Contracts\Middleware;

final readonly class Pipeline
{
    /**
     * @param Middleware[] $middlewares
     */
    public function __construct(
        private array $middlewares,
    ) {
    }

    public function send(
        mixed $message,
        callable $destination,
    ): mixed {

        $pipeline = array_reduce(

            array_reverse($this->middlewares),

            function (callable $next, Middleware $middleware) {

                return fn (mixed $message)
                    => $middleware->process($message, $next);

            },

            $destination,
        );

        return $pipeline($message);
    }
}
