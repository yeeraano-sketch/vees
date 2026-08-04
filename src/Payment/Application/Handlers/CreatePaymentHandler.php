<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Application\Handlers;

use Vees\Core\SharedKernel\Application\Contracts\UnitOfWork;
use Vees\Core\Payment\Application\Commands\CreatePaymentCommand;
use Vees\Core\Payment\Domain\Aggregates\Payment\PaymentFactory;
use Vees\Core\Payment\Domain\Contracts\PaymentRepository;
use Vees\Core\Payment\Domain\Enums\PaymentMethod;
use Vees\Core\Payment\Domain\ValueObjects\Money;
use Vees\Core\Payment\Domain\ValueObjects\PaymentId;
use Vees\Core\SharedKernel\Application\Contracts\Command;
use Vees\Core\SharedKernel\Application\Contracts\CommandHandler;
use Vees\Core\SharedKernel\Contracts\UuidGenerator;

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
