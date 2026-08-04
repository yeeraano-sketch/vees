<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Pipeline;

use Vees\Core\SharedKernel\Application\Contracts\Middleware;

final class MiddlewarePipeline
{
    /**
     * @var Middleware[]
     */
    private array $middlewares = [];

    public function pipe(
        Middleware $middleware,
    ): self {

        $this->middlewares[] = $middleware;

        return $this;
    }

    public function build(): Pipeline
    {
        return new Pipeline($this->middlewares);
    }
}
