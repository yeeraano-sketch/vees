<?php

declare(strict_types=1);

namespace App\Notification\Application\QueryHandlers;

use App\Framework\Application\Handlers\QueryHandler;
use App\Notification\Application\Queries\GetNotificationByIdQuery;
use App\Notification\Domain\Contracts\NotificationRepository;
use App\Notification\Domain\ValueObjects\NotificationId;

final readonly class GetNotificationByIdHandler implements QueryHandler
{
    public function __construct(
        private NotificationRepository $repository,
    ) {
    }

    public function handle(
        GetNotificationByIdQuery $query,
    ): mixed {

        return $this->repository->findById(
            NotificationId::fromString($query->notificationId)
        );
    }
}
