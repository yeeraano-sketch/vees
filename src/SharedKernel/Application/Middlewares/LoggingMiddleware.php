<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Middlewares;

use Psr\Log\LoggerInterface;
use Vees\Core\SharedKernel\Application\Contracts\Middleware;

final readonly class LoggingMiddleware implements Middleware
{
    public function __construct(
        private ?LoggerInterface $logger = null,
    ) {}

    public function process(
        mixed $message,
        callable $next,
    ): mixed {
        $this->logger?->info('Processing message', [
            'type' => get_class($message),
        ]);

        $result = $next($message);

        $this->logger?->info('Message processed', [
            'type' => get_class($message),
        ]);

        return $result;
    }
}
