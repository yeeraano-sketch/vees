<?php

declare(strict_types=1);

namespace App\Provider\Domain\Entities;

use App\Provider\Domain\ValueObjects\AvailabilityStatus;
use App\SharedKernel\Domain\Entity;

final class ProviderAvailability extends Entity
{
    public function __construct(
        private AvailabilityStatus $status,
    ) {
    }

    protected function identity(): mixed
    {
        return 'availability';
    }

    public function status(): AvailabilityStatus
    {
        return $this->status;
    }

    public function changeStatus(AvailabilityStatus $status): void
    {
        $this->status = $status;
    }

    public function isAvailable(): bool
    {
        return $this->status === AvailabilityStatus::Available;
    }

    public function isBusy(): bool
    {
        return $this->status === AvailabilityStatus::Busy;
    }

    public function isOffline(): bool
    {
        return $this->status === AvailabilityStatus::Offline;
    }
}
