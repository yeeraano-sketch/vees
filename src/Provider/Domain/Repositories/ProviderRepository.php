<?php

declare(strict_types=1);

namespace App\Provider\Domain\Repositories;

use App\Provider\Domain\Aggregates\Provider;
use App\Provider\Domain\ValueObjects\ProviderId;

interface ProviderRepository
{
    public function save(Provider $provider): void;

    public function findById(ProviderId $id): ?Provider;
}
