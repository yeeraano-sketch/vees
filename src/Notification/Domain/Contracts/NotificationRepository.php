<?php

declare(strict_types=1);

namespace App\Notification\Domain\Contracts;

use App\Notification\Domain\Aggregates\Notification\Notification;
use App\Notification\Domain\ValueObjects\NotificationId;

interface NotificationRepository
{
    public function save(
        Notification $notification,
    ): void;

    public function findById(
        NotificationId $id,
    ): ?Notification;

    public function exists(
        NotificationId $id,
    ): bool;

    public function delete(
        Notification $notification,
    ): void;
}
