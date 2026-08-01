<?php

declare(strict_types=1);

namespace App\Matching\Application\QueryHandlers;

use App\Framework\Application\Handlers\QueryHandler;
use App\Matching\Application\Queries\GetMatchingByIdQuery;
use App\Matching\Domain\Contracts\MatchingRepository;
use App\Matching\Domain\ValueObjects\MatchingId;

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
