<?php

declare(strict_types=1);

namespace Vees\Core\Session\Application\QueryHandlers;

use Vees\Core\Framework\Application\Handlers\QueryHandler;
use Vees\Core\Session\Application\Queries\GetSessionByIdQuery;
use Vees\Core\Session\Domain\Contracts\SessionRepository;
use Vees\Core\Session\Domain\ValueObjects\SessionId;

final readonly class GetSessionByIdHandler implements QueryHandler
{
    public function __construct(
        private SessionRepository $repository,
    ) {}

    public function handle(
        GetSessionByIdQuery $query,
    ): mixed {

        return $this->repository->findById(
            SessionId::fromString($query->sessionId)
        );
    }
}
