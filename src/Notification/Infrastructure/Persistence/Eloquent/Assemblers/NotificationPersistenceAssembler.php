<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Infrastructure\Persistence\Eloquent\Assemblers;

use Vees\Core\Notification\Domain\Aggregates\Notification\Notification;
use Vees\Core\Notification\Infrastructure\Persistence\Eloquent\Mappers\NotificationMapper;
use Vees\Core\Notification\Infrastructure\Persistence\Eloquent\Models\NotificationModel;

final readonly class NotificationPersistenceAssembler
{
    public function __construct(
        private NotificationMapper $mapper,
    ) {}

    public function persist(
        Notification $notification,
    ): NotificationModel {

        $model = $this->mapper->toModel($notification);

        $model->save();

        return $model;
    }
}
