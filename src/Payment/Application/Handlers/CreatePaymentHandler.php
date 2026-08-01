<?php

declare(strict_types=1);

namespace App\Payment\Application\Handlers;

use App\SharedKernel\Application\Contracts\UnitOfWork;
use App\Payment\Application\Commands\CreatePaymentCommand;
use App\Payment\Domain\Aggregates\Payment\PaymentFactory;
use App\Payment\Domain\Contracts\PaymentRepository;
use App\Payment\Domain\Enums\PaymentMethod;
use App\Payment\Domain\ValueObjects\Money;
use App\Payment\Domain\ValueObjects\PaymentId;
use App\SharedKernel\Application\Contracts\Command;
use App\SharedKernel\Application\Contracts\CommandHandler;
use App\SharedKernel\Contracts\UuidGenerator;

final readonly class CreatePaymentHandler implements CommandHandler
{
    public function __construct(
        private PaymentFactory $factory,
        private PaymentRepository $repository,
        private UnitOfWork $unitOfWork,
        private UuidGenerator $uuid,
    ) {
    }

    public function handle(
        Command $command,
    ): mixed {

        /** @var CreatePaymentCommand $command */

        $payment = $this->factory->create(

            id: PaymentId::fromString(
                $this->uuid->generate()
            ),

            providerId: $command->providerId,

            subscriptionId: $command->subscriptionId,

            money: new Money(
                amount: $command->amount,
                currency: $command->currency,
            ),

            method: PaymentMethod::from(
                $command->method
            ),
        );

        $this->repository->save($payment);

        $this->unitOfWork->commit();

        return $payment;
    }
}
