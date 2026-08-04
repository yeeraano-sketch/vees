<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Infrastructure\Persistence\Eloquent\Repositories;

use Vees\Core\Provider\Domain\Aggregates\Provider\Provider;
use Vees\Core\Provider\Domain\Contracts\ProviderRepository;
use Vees\Core\Provider\Domain\ValueObjects\ProviderId;
use Vees\Core\Provider\Infrastructure\Persistence\Eloquent\Assemblers\ProviderPersistenceAssembler;

final readonly class EloquentProviderRepository implements ProviderRepository
{
    public function __construct(
        private ProviderPersistenceAssembler $assembler,
        private AggregateCollector $collector,
    ) {}

    public function save(
        Provider $provider,
    ): void {

        $this->assembler->persist($provider);

        $this->collector->add($provider);
    }

    public function findById(
        ProviderId $id,
    ): ?Provider {

        return null;
    }

    public function exists(
        ProviderId $id,
    ): bool {

        return false;
    }

    public function delete(
        Provider $provider,
    ): void {}
}
