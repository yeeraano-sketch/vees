<?php

declare(strict_types=1);

namespace App\Subscription\Application\Handlers;

use App\SharedKernel\Application\Contracts\UnitOfWork;
use App\SharedKernel\Application\Contracts\Command;
use App\SharedKernel\Application\Contracts\CommandHandler;
use App\SharedKernel\Contracts\Clock;
use App\SharedKernel\Contracts\UuidGenerator;

use App\Subscription\Application\Commands\CreateSubscriptionCommand;

use App\Subscription\Domain\Aggregates\Subscription\SubscriptionFactory;
use App\Subscription\Domain\Contracts\SubscriptionRepository;
use App\Subscription\Domain\Enums\SubscriptionPlan;
use App\Subscription\Domain\ValueObjects\SubscriptionId;
use App\Subscription\Domain\ValueObjects\SubscriptionPeriod;

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
