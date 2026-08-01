<?php

declare(strict_types=1);

namespace App\Provider\Application\QueryHandlers;

use App\Framework\Application\Handlers\QueryHandler;
use App\Provider\Application\DTOs\ProviderDto;
use App\Provider\Application\Queries\GetProviderByIdQuery;
use App\Provider\Domain\Contracts\ProviderRepository;
use App\Provider\Domain\ValueObjects\ProviderId;

final readonly class GetProviderByIdHandler implements QueryHandler
{
    public function __construct(
        private ProviderRepository $repository,
    ) {
    }

    public function handle(
        GetProviderByIdQuery $query,
    ): ?ProviderDto {

        $provider = $this->repository->findById(
            ProviderId::fromString($query->providerId)
        );

        if ($provider === null) {
            return null;
        }

        return ProviderDto::fromAggregate($provider);
    }
}