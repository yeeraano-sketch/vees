<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Application\Handlers;

use Vees\Core\SharedKernel\Application\Contracts\UnitOfWork;
use Vees\Core\Notification\Application\Commands\CreateNotificationCommand;
use Vees\Core\Notification\Domain\Aggregates\Notification\NotificationFactory;
use Vees\Core\Notification\Domain\Contracts\NotificationRepository;
use Vees\Core\Notification\Domain\ValueObjects\NotificationId;
use Vees\Core\SharedKernel\Application\Contracts\Command;
use Vees\Core\SharedKernel\Application\Contracts\CommandHandler;
use Vees\Core\SharedKernel\Contracts\UuidGenerator;

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
