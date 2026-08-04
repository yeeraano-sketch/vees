<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Application\QueryHandlers;

use Vees\Core\Framework\Application\Handlers\QueryHandler;
use Vees\Core\Matching\Application\Queries\GetMatchingByIdQuery;
use Vees\Core\Matching\Domain\Contracts\MatchingRepository;
use Vees\Core\Matching\Domain\ValueObjects\MatchingId;

final readonly class GetMatchingByIdHandler implements QueryHandler
{
    public function __construct(
        private MatchingRepository $repository,
    ) {
    }

    public function handle(
        GetMatchingByIdQuery $query,
    ): mixed {

        return $this->repository->findById(
            MatchingId::fromString($query->matchingId)
        );
    }
}
