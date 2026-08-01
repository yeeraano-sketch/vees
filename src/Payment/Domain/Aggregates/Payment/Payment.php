<?php

declare(strict_types=1);

namespace App\Payment\Domain\Aggregates\Payment;

use App\Payment\Domain\Enums\PaymentMethod;
use App\Payment\Domain\Enums\PaymentStatus;
use App\Payment\Domain\Events\PaymentCreated;
use App\Payment\Domain\Events\PaymentCompleted;
use App\Payment\Domain\Events\PaymentFailed;
use App\Payment\Domain\ValueObjects\Money;
use App\Payment\Domain\ValueObjects\PaymentId;
use App\SharedKernel\Domain\AggregateRoot;

final class Payment extends AggregateRoot
{
    private function __construct(
        private PaymentId $id,
        private string $providerId,
        private string $subscriptionId,
        private Money $money,
        private PaymentMethod $method,
        private PaymentStatus $status,
    ) {
    }

    public static function create(
        PaymentId $id,
        string $providerId,
        string $subscriptionId,
        Money $money,
        PaymentMethod $method,
    ): self {

        $payment = new self(
            id: $id,
            providerId: $providerId,
            subscriptionId: $subscriptionId,
            money: $money,
            method: $method,
            status: PaymentStatus::Pending,
        );

        $payment->recordEvent(
            new PaymentCreated($id)
        );

        return $payment;
    }

    public function complete(): void
    {
        if ($this->status === PaymentStatus::Paid) {
            return;
        }

        $this->status = PaymentStatus::Paid;

        $this->recordEvent(
            new PaymentCompleted($this->id)
        );
    }

    public function fail(): void
    {
        if ($this->status === PaymentStatus::Failed) {
            return;
        }

        $this->status = PaymentStatus::Failed;

        $this->recordEvent(
            new PaymentFailed($this->id)
        );
    }

    public function id(): PaymentId
    {
        return $this->id;
    }

    public function status(): PaymentStatus
    {
        return $this->status;
    }

    public function snapshot(): array
    {
        return [

            'id' => (string) $this->id,

            'provider_id' => $this->providerId,

            'subscription_id' => $this->subscriptionId,

            'amount' => $this->money->toArray(),

            'method' => $this->method->value,

            'status' => $this->status->value,
        ];
    }
}
