<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Domain\Aggregates\Payment;

use Vees\Core\Payment\Domain\Enums\PaymentMethod;
use Vees\Core\Payment\Domain\Enums\PaymentStatus;
use Vees\Core\Payment\Domain\Events\PaymentCompleted;
use Vees\Core\Payment\Domain\Events\PaymentCreated;
use Vees\Core\Payment\Domain\Events\PaymentFailed;
use Vees\Core\Payment\Domain\Events\PaymentRefunded;
use Vees\Core\Payment\Domain\Exceptions\InvalidPaymentState;
use Vees\Core\Payment\Domain\ValueObjects\Money;
use Vees\Core\Payment\Domain\ValueObjects\PaymentId;
use Vees\Core\SharedKernel\Domain\AggregateRoot;

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

        $payment->recordEvent(new PaymentCreated($id->value()));

        return $payment;
    }

    public function complete(): void
    {
        if ($this->status !== PaymentStatus::Pending) {
            throw new InvalidPaymentState(
                sprintf('Cannot complete payment in "%s" status.', $this->status->value)
            );
        }

        $this->status = PaymentStatus::Paid;
        $this->recordEvent(new PaymentCompleted($this->id->value()));
    }

    public function fail(): void
    {
        if ($this->status !== PaymentStatus::Pending) {
            throw new InvalidPaymentState(
                sprintf('Cannot fail payment in "%s" status.', $this->status->value)
            );
        }

        $this->status = PaymentStatus::Failed;
        $this->recordEvent(new PaymentFailed($this->id->value()));
    }

    public function refund(): void
    {
        if ($this->status !== PaymentStatus::Paid) {
            throw new InvalidPaymentState(
                sprintf('Can only refund a paid payment. Current status: "%s".', $this->status->value)
            );
        }

        $this->status = PaymentStatus::Refunded;
        $this->recordEvent(new PaymentRefunded($this->id->value()));
    }

    public function cancel(): void
    {
        if ($this->status !== PaymentStatus::Pending) {
            throw new InvalidPaymentState(
                sprintf('Can only cancel a pending payment. Current status: "%s".', $this->status->value)
            );
        }

        $this->status = PaymentStatus::Cancelled;
    }

    protected function identity(): mixed
    {
        return $this->id;
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
            'id'            => (string) $this->id,
            'provider_id'     => $this->providerId,
            'subscription_id' => $this->subscriptionId,
            'amount'         => $this->money->toArray(),
            'method'         => $this->method->value,
            'status'         => $this->status->value,
        ];
    }
}
