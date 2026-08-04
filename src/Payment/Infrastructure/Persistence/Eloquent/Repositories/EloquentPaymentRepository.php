<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Infrastructure\Persistence\Eloquent\Repositories;

use Vees\Core\Payment\Domain\Aggregates\Payment\Payment;
use Vees\Core\Payment\Domain\Contracts\PaymentRepository;
use Vees\Core\Payment\Domain\ValueObjects\PaymentId;
use Vees\Core\Payment\Infrastructure\Persistence\Eloquent\Assemblers\PaymentPersistenceAssembler;
use Vees\Core\Payment\Infrastructure\Persistence\Eloquent\Models\PaymentModel;
use Vees\Core\SharedKernel\Application\Transactions\AggregateCollector;

final readonly class EloquentPaymentRepository implements PaymentRepository
{
    public function __construct(
        private PaymentPersistenceAssembler $assembler,
        private AggregateCollector $collector,
    ) {
    }

    public function save(
        Payment $payment,
    ): void {

        $this->assembler->persist($payment);

        $this->collector->add($payment);
    }

    public function findById(
        PaymentId $id,
    ): ?Payment {

        // سيتم تنفيذ Hydration لاحقاً.
        return null;
    }

    public function exists(
        PaymentId $id,
    ): bool {

        return PaymentModel::query()
            ->whereKey((string) $id)
            ->exists();
    }

    public function delete(
        Payment $payment,
    ): void {

        PaymentModel::query()
            ->whereKey((string) $payment->id())
            ->delete();
    }
}
