<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Domain\Aggregates\Subscription;

use Vees\Core\SharedKernel\Domain\AggregateRoot;
use Vees\Core\Subscription\Domain\Enums\SubscriptionPlan;
use Vees\Core\Subscription\Domain\Enums\SubscriptionStatus;
use Vees\Core\Subscription\Domain\Events\SubscriptionActivated;
use Vees\Core\Subscription\Domain\Events\SubscriptionCreated;
use Vees\Core\Subscription\Domain\Events\SubscriptionExpired;
use Vees\Core\Subscription\Domain\ValueObjects\SubscriptionId;
use Vees\Core\Subscription\Domain\ValueObjects\SubscriptionPeriod;

final class Subscription extends AggregateRoot
{
    private function __construct(
        private SubscriptionId $id,
        private string $providerId,
        private SubscriptionPlan $plan,
        private SubscriptionStatus $status,
        private SubscriptionPeriod $period,
    ) {}

    public static function create(
        SubscriptionId $id,
        string $providerId,
        SubscriptionPlan $plan,
        SubscriptionPeriod $period,
    ): self {

        $subscription = new self(
            id: $id,
            providerId: $providerId,
            plan: $plan,
            status: SubscriptionStatus::Pending,
            period: $period,
        );

        $subscription->recordEvent(
            new SubscriptionCreated($id)
        );

        return $subscription;
    }

    public function activate(): void
    {
        if ($this->status === SubscriptionStatus::Active) {
            return;
        }

        $this->status = SubscriptionStatus::Active;

        $this->recordEvent(
            new SubscriptionActivated($this->id)
        );
    }

    public function expire(): void
    {
        if ($this->status === SubscriptionStatus::Expired) {
            return;
        }

        $this->status = SubscriptionStatus::Expired;

        $this->recordEvent(
            new SubscriptionExpired($this->id)
        );
    }

    public function id(): SubscriptionId
    {
        return $this->id;
    }

    public function providerId(): string
    {
        return $this->providerId;
    }

    public function plan(): SubscriptionPlan
    {
        return $this->plan;
    }

    public function status(): SubscriptionStatus
    {
        return $this->status;
    }

    public function period(): SubscriptionPeriod
    {
        return $this->period;
    }

    public function snapshot(): array
    {
        return [

            'id' => (string) $this->id,

            'provider_id' => $this->providerId,

            'plan' => $this->plan->value,

            'status' => $this->status->value,

            'period' => $this->period->toArray(),
        ];
    }
}
