<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Payment\Domain;

use PHPUnit\Framework\TestCase;
use Vees\Core\Payment\Domain\Aggregates\Payment\Payment;
use Vees\Core\Payment\Domain\Enums\PaymentMethod;
use Vees\Core\Payment\Domain\Enums\PaymentStatus;
use Vees\Core\Payment\Domain\Exceptions\InvalidPaymentState;
use Vees\Core\Payment\Domain\ValueObjects\Money;
use Vees\Core\Payment\Domain\ValueObjects\PaymentId;

final class PaymentInvariantsTest extends TestCase
{
    private Payment $payment;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payment = Payment::create(
            id: PaymentId::fromString('pay-1'),
            providerId: 'provider-1',
            subscriptionId: 'sub-1',
            money: new Money(100, 'SAR'),
            method: PaymentMethod::Card,
        );
    }

    public function test_cannot_complete_already_paid_payment(): void
    {
        $this->payment->complete();

        $this->expectException(InvalidPaymentState::class);
        $this->expectExceptionMessage('Cannot complete payment in "paid" status.');

        $this->payment->complete();
    }

    public function test_cannot_fail_completed_payment(): void
    {
        $this->payment->complete();

        $this->expectException(InvalidPaymentState::class);
        $this->expectExceptionMessage('Cannot fail payment in "paid" status.');

        $this->payment->fail();
    }

    public function test_can_refund_paid_payment(): void
    {
        $this->payment->complete();
        $this->payment->refund();

        $this->assertEquals(PaymentStatus::Refunded, $this->payment->status());
    }

    public function test_cannot_refund_pending_payment(): void
    {
        $this->expectException(InvalidPaymentState::class);
        $this->expectExceptionMessage('Can only refund a paid payment. Current status: "pending".');

        $this->payment->refund();
    }

    public function test_cannot_refund_already_refunded_payment(): void
    {
        $this->payment->complete();
        $this->payment->refund();

        $this->expectException(InvalidPaymentState::class);
        $this->expectExceptionMessage('Can only refund a paid payment. Current status: "refunded".');

        $this->payment->refund();
    }
}
