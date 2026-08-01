<?php

declare(strict_types=1);

namespace App\Notification\Infrastructure\Persistence\Eloquent\Mappers;

use App\Notification\Domain\Aggregates\Notification\Notification;
use App\Notification\Infrastructure\Persistence\Eloquent\Models\NotificationModel;

final class NotificationMapper
{
    public function toModel(
        Notification $notification,
        ?NotificationModel $model = null,
    ): NotificationModel {

        $model ??= new NotificationModel();

        $snapshot = $notification->snapshot();

        $model->id = $snapshot['id'];

        $model->recipient_id = $snapshot['recipient_id'];

        $model->title = $snapshot['title'];

        $model->message = $snapshot['message'];

        $model->status = $snapshot['status'];

        return $model;
    }

    public function toDomain(
        NotificationModel $model,
    ): Notification {

        throw new \LogicException(
            'Hydration is not implemented yet.'
        );
    }
}
