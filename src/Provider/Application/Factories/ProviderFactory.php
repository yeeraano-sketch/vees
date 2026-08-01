<?php

declare(strict_types=1);

namespace App\Provider\Application\Factories;

use App\Provider\Application\Commands\RegisterProviderCommand;
use App\Provider\Domain\Aggregates\Provider\Provider;

interface ProviderFactory
{
    public function create(RegisterProviderCommand $command): Provider;
}
