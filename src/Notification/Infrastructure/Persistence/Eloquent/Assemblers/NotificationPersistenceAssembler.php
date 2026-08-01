<?php

declare(strict_types=1);

namespace App\Notification\Infrastructure\Persistence\Eloquent\Assemblers;

use App\Notification\Domain\Aggregates\Notification\Notification;
use App\Notification\Infrastructure\Persistence\Eloquent\Mappers\NotificationMapper;
use App\Notification\Infrastructure\Persistence\Eloquent\Models\NotificationModel;

final readonly class NotificationPersistenceAssembler
{
    public function __construct(
        private NotificationMapper $mapper,
    ) {
    }

    public function persist(
        Notification $notification,
    ): NotificationModel {

        $model = $this->mapper->toModel($notification);

        $model->save();

        return $model;
    }
}
