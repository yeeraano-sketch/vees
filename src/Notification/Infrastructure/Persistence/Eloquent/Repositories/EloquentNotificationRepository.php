<?php

declare(strict_types=1);

namespace Vees\Core\Notification\Infrastructure\Persistence\Eloquent\Repositories;

use Vees\Core\Notification\Domain\Aggregates\Notification\Notification;
use Vees\Core\Notification\Domain\Contracts\NotificationRepository;
use Vees\Core\Notification\Domain\ValueObjects\NotificationId;
use Vees\Core\Notification\Infrastructure\Persistence\Eloquent\Assemblers\NotificationPersistenceAssembler;
use Vees\Core\Notification\Infrastructure\Persistence\Eloquent\Models\NotificationModel;
use Vees\Core\SharedKernel\Application\Transactions\AggregateCollector;

final readonly class EloquentNotificationRepository implements NotificationRepository
{
    public function __construct(
        private NotificationPersistenceAssembler $assembler,
        private AggregateCollector $collector,
    ) {}

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
