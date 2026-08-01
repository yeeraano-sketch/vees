<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Bus;

use App\SharedKernel\Application\Contracts\Command;
use App\SharedKernel\Application\Dispatcher\HandlerResolver;
use App\SharedKernel\Application\Pipeline\Pipeline;

final readonly class CommandBus
{
    public function __construct(
        private HandlerResolver $resolver,
        private Pipeline $pipeline,
    ) {
    }

    public function dispatch(
        Command $command,
    ): mixed {

        return $this->pipeline->send(

            $command,

            function (Command $command) {

                $handler = $this->resolver->resolve($command);

                return $handler->handle($command);

            }

        );
    }
}
