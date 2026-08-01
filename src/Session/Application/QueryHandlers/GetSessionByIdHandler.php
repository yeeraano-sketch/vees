<?php

declare(strict_types=1);

namespace App\Session\Application\QueryHandlers;

use App\Framework\Application\Handlers\QueryHandler;
use App\Session\Application\Queries\GetSessionByIdQuery;
use App\Session\Domain\Contracts\SessionRepository;
use App\Session\Domain\ValueObjects\SessionId;

final readonly class GetSessionByIdHandler implements QueryHandler
{
    public function __construct(
        private SessionRepository $repository,
    ) {
    }

    public function handle(
        GetSessionByIdQuery $query,
    ): mixed {

        return $this->repository->findById(
            SessionId::fromString($query->sessionId)
        );
    }
}
