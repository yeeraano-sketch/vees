<?php

declare(strict_types=1);

namespace App\Provider\Domain\Aggregates;

use App\Provider\Domain\Events\ProviderActivated;
use App\Provider\Domain\Events\ProviderRegistered;
use App\Provider\Domain\Events\ProviderSuspended;
use App\Provider\Domain\Events\WorkModeChanged;
use App\Provider\Domain\ValueObjects\Availability;
use App\Provider\Domain\ValueObjects\ProviderId;
use App\Provider\Domain\ValueObjects\ProviderStatus;
use App\Provider\Domain\ValueObjects\WorkMode;
use App\SharedKernel\Domain\AggregateRoot;

final class Provider extends AggregateRoot
{
    private ProviderStatus $status;

    private Availability $availability;

    private WorkMode $workMode;

    private function __construct(
        private readonly ProviderId $id,
    ) {
        $this->status = ProviderStatus::Pending;
        $this->availability = Availability::Offline;
        $this->workMode = WorkMode::Taxi;
    }

    public static function register(
        ProviderId $id,
    ): self {
        $provider = new self($id);

        $provider->record(
            new ProviderRegistered(
                $id->toString(),
            )
        );

        return $provider;
    }

    public function activate(): void
    {
        if ($this->status === ProviderStatus::Active) {
            return;
        }

        $this->status = ProviderStatus::Active;

        $this->record(
            new ProviderActivated(
                $this->id->toString(),
            )
        );
    }

    public function suspend(): void
    {
        if ($this->status === ProviderStatus::Suspended) {
            return;
        }

        $this->status = ProviderStatus::Suspended;

        $this->availability = Availability::Offline;

        $this->record(
            new ProviderSuspended(
                $this->id->toString(),
            )
        );
    }

    public function changeWorkMode(
        WorkMode $mode,
    ): void {
        if ($this->workMode === $mode) {
            return;
        }

        $this->workMode = $mode;

        $this->record(
            new WorkModeChanged(
                $this->id->toString(),
                $mode->value,
            )
        );
    }

    public function id(): ProviderId
    {
        return $this->id;
    }

    public function status(): ProviderStatus
    {
        return $this->status;
    }

    public function availability(): Availability
    {
        return $this->availability;
    }

    public function workMode(): WorkMode
    {
        return $this->workMode;
    }
}
