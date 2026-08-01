<?php

declare(strict_types=1);

namespace App\Provider\Domain\Entities;

use App\Provider\Domain\ValueObjects\WorkMode;
use App\SharedKernel\Domain\Entity;

final class ProviderSettings extends Entity
{
    public function __construct(
        private WorkMode $workMode,
    ) {
    }

    protected function identity(): mixed
    {
        return 'settings';
    }

    public function workMode(): WorkMode
    {
        return $this->workMode;
    }

    public function changeWorkMode(WorkMode $workMode): void
    {
        $this->workMode = $workMode;
    }
}
