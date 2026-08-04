<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Application\QueryHandlers;

use Vees\Core\Framework\Application\Handlers\QueryHandler;
use Vees\Core\Provider\Application\DTOs\ProviderDto;
use Vees\Core\Provider\Application\Queries\GetProviderByIdQuery;
use Vees\Core\Provider\Domain\Contracts\ProviderRepository;
use Vees\Core\Provider\Domain\ValueObjects\ProviderId;

final readonly class GetProviderByIdHandler implements QueryHandler
{
    public function __construct(
        private ProviderRepository $repository,
    ) {}

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
