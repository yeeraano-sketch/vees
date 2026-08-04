<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Application\QueryHandlers;

use Vees\Core\Framework\Application\Handlers\QueryHandler;
use Vees\Core\Notification\Application\Queries\GetNotificationByIdQuery;
use Vees\Core\Notification\Domain\Contracts\NotificationRepository;
use Vees\Core\Notification\Domain\ValueObjects\NotificationId;

final readonly class GetNotificationByIdHandler implements QueryHandler
{
    public function __construct(
        private NotificationRepository $repository,
    ) {}

    public function handle(
        GetNotificationByIdQuery $query,
    ): mixed {

        return $this->repository->findById(
            NotificationId::fromString($query->notificationId)
        );
    }
}
