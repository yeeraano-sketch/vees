<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Contracts;

use Vees\Core\Provider\Domain\Aggregates\Provider\Provider;
use Vees\Core\Provider\Domain\ValueObjects\ProviderId;

interface ProviderRepository
{
    public function save(Provider $provider): void;

    public function findById(ProviderId $id): ?Provider;

    public function exists(ProviderId $id): bool;

    public function delete(Provider $provider): void;
}
