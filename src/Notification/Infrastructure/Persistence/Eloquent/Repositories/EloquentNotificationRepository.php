<?php

declare(strict_types=1);

namespace App\Notification\Infrastructure\Persistence\Eloquent\Repositories;

use App\Notification\Domain\Aggregates\Notification\Notification;
use App\Notification\Domain\Contracts\NotificationRepository;
use App\Notification\Domain\ValueObjects\NotificationId;
use App\Notification\Infrastructure\Persistence\Eloquent\Assemblers\NotificationPersistenceAssembler;
use App\Notification\Infrastructure\Persistence\Eloquent\Models\NotificationModel;
use App\SharedKernel\Application\Transactions\AggregateCollector;

final readonly class EloquentNotificationRepository implements NotificationRepository
{
    public function __construct(
        private NotificationPersistenceAssembler $assembler,
        private AggregateCollector $collector,
    ) {
    }

    public function save(
        Notification $notification,
    ): void {

        $this->assembler->persist($notification);

        $this->collector->add($notification);
    }

    public function findById(
        NotificationId $id,
    ): ?Notification {

        // سيتم تنفيذ Hydration في Milestone لاحق.
        return null;
    }

    public function exists(
        NotificationId $id,
    ): bool {

        return NotificationModel::query()
            ->whereKey((string) $id)
            ->exists();
    }

    public function delete(
        Notification $notification,
    ): void {

        NotificationModel::query()
            ->whereKey((string) $notification->id())
            ->delete();
    }
}
