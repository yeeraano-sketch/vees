<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Bus;

use Vees\Core\Framework\Dispatcher\HandlerResolver;
use Vees\Core\SharedKernel\Application\Contracts\Command;
use Vees\Core\SharedKernel\Application\Pipeline\Pipeline;

final readonly class CommandBus
{
    public function __construct(
        private HandlerResolver $resolver,
        private Pipeline $pipeline,
    ) {}

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
