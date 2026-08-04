<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Application\Handlers;

use Vees\Core\SharedKernel\Application\Contracts\UnitOfWork;
use Vees\Core\SharedKernel\Application\Contracts\Command;
use Vees\Core\SharedKernel\Application\Contracts\CommandHandler;
use Vees\Core\SharedKernel\Contracts\Clock;
use Vees\Core\SharedKernel\Contracts\UuidGenerator;

use Vees\Core\Subscription\Application\Commands\CreateSubscriptionCommand;

use Vees\Core\Subscription\Domain\Aggregates\Subscription\SubscriptionFactory;
use Vees\Core\Subscription\Domain\Contracts\SubscriptionRepository;
use Vees\Core\Subscription\Domain\Enums\SubscriptionPlan;
use Vees\Core\Subscription\Domain\ValueObjects\SubscriptionId;
use Vees\Core\Subscription\Domain\ValueObjects\SubscriptionPeriod;

final readonly class CreateSubscriptionHandler implements CommandHandler
{
    public function __construct(
        private SubscriptionFactory $factory,
        private SubscriptionRepository $repository,
        private UnitOfWork $unitOfWork,
        private UuidGenerator $uuid,
        private Clock $clock,
    ) {
    }

    public function handle(
        Command $command,
    ): mixed {

        /** @var CreateSubscriptionCommand $command */

        $startsAt = $this->clock->now();

        $endsAt = match ($command->plan) {

            'trial' => $startsAt->modify('+14 days'),

            'monthly' => $startsAt->modify('+1 month'),

            'quarterly' => $startsAt->modify('+3 months'),

            'yearly' => $startsAt->modify('+1 year'),

            default => throw new \InvalidArgumentException(
                'Invalid subscription plan.'
            ),
        };

        $subscription = $this->factory->create(

            id: SubscriptionId::fromString(
                $this->uuid->generate()
            ),

            providerId: $command->providerId,

            plan: SubscriptionPlan::from(
                $command->plan
            ),

            period: new SubscriptionPeriod(
                $startsAt,
                $endsAt,
            ),
        );

        $this->repository->save($subscription);

        $this->unitOfWork->commit();

        return $subscription;
    }
}
