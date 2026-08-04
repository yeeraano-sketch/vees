<?php

declare(strict_types=1);

namespace Vees\Core\Framework\Dispatcher;

use Illuminate\Contracts\Container\Container;
use RuntimeException;

final class HandlerResolver
{
    /**
     * @var array<class-string,class-string>
     */
    private array $handlers = [];

    public function __construct(
        private readonly Container $container,
    ) {
    }

    public function register(
        string $command,
        string $handler,
    ): void {
        $this->handlers[$command] = $handler;
    }

    public function resolve(
        object $command,
    ): object {

        $handler = $this->handlers[$command::class] ?? null;

        if ($handler === null) {
            throw new RuntimeException(
                sprintf(
                    'No handler registered for command [%s].',
                    $command::class
                )
            );
        }

        return $this->container->make($handler);
    }
}
