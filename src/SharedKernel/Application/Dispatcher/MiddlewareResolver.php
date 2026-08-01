<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Dispatcher;

use Illuminate\Contracts\Container\Container;

final readonly class MiddlewareResolver
{
    public function __construct(
        private Container $container,
    ) {
    }

    /**
     * @param list<class-string> $middlewares
     *
     * @return list<object>
     */
    public function resolve(
        array $middlewares,
    ): array {

        return array_map(

            fn (string $middleware) =>

                $this->container->make($middleware),

            $middlewares,

        );
    }
}
