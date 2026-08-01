<?php

declare(strict_types=1);

namespace App\Notification\Application\Handlers;

use App\Framework\Persistence\UnitOfWork;
use App\Notification\Application\Commands\CreateNotificationCommand;
use App\Notification\Domain\Aggregates\Notification\NotificationFactory;
use App\Notification\Domain\Contracts\NotificationRepository;
use App\Notification\Domain\ValueObjects\NotificationId;
use App\SharedKernel\Application\Contracts\Command;
use App\SharedKernel\Application\Contracts\CommandHandler;
use App\SharedKernel\Contracts\UuidGenerator;

final readonly class CreateNotificationHandler implements CommandHandler
{
    public function __construct(
        private NotificationFactory $factory,
        private NotificationRepository $repository,
        private UnitOfWork $unitOfWork,
        private UuidGenerator $uuid,
    ) {
    }

    public function handle(
        Command $command,
    ): mixed {

        /** @var CreateNotificationCommand $command */

        $notification = $this->factory->create(

            id: NotificationId::fromString(
                $this->uuid->generate()
            ),

            recipientId: $command->recipientId,

            title: $command->title,

            message: $command->message,
        );

        $this->repository->save($notification);

        $this->unitOfWork->commit();

        return $notification;
    }
}
