<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Domain\Contracts;

use Vees\Core\Notification\Domain\Aggregates\Notification\Notification;
use Vees\Core\Notification\Domain\ValueObjects\NotificationId;

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
