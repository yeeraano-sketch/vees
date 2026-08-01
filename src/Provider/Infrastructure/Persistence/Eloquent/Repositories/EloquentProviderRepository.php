<?php

declare(strict_types=1);

namespace App\Provider\Infrastructure\Persistence\Eloquent\Repositories;

use App\Provider\Domain\Aggregates\Provider\Provider;
use App\Provider\Domain\Contracts\ProviderRepository;
use App\Provider\Domain\ValueObjects\ProviderId;
use App\Provider\Infrastructure\Persistence\Eloquent\Assemblers\ProviderPersistenceAssembler;

final readonly class EloquentProviderRepository implements ProviderRepository
{
    public function __construct(
        private ProviderPersistenceAssembler $assembler,
    ) {
    }

    public function save(
        Provider $provider,
    ): void {

        $this->assembler->persist($provider);
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
    ): void {
    }
}
