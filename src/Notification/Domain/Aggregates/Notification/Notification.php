<?php

declare(strict_types=1);

namespace App\Notification\Domain\Aggregates\Notification;

use App\Notification\Domain\Enums\NotificationStatus;
use App\Notification\Domain\Events\NotificationCreated;
use App\Notification\Domain\Exceptions\NotificationCannotBeSent;
use App\Notification\Domain\ValueObjects\NotificationId;
use App\SharedKernel\Domain\AggregateRoot;

final class Notification extends AggregateRoot
{
    private function __construct(
        private NotificationId $id,
        private string $recipientId,
        private string $title,
        private string $message,
        private NotificationStatus $status,
    ) {
    }

    public static function create(
        NotificationId $id,
        string $recipientId,
        string $title,
        string $message,
    ): self {

        $notification = new self(
            id: $id,
            recipientId: $recipientId,
            title: $title,
            message: $message,
            status: NotificationStatus::Pending,
        );

        $notification->recordEvent(
            new NotificationCreated($id)
        );

        return $notification;
    }

    public function markAsSent(): void
    {
        if ($this->status !== NotificationStatus::Pending) {
            throw new NotificationCannotBeSent();
        }

        $this->status = NotificationStatus::Sent;
    }

    public function markAsFailed(): void
    {
        if ($this->status !== NotificationStatus::Pending) {
            throw new NotificationCannotBeSent();
        }

        $this->status = NotificationStatus::Failed;
    }

    public function id(): NotificationId
    {
        return $this->id;
    }

    public function status(): NotificationStatus
    {
        return $this->status;
    }

    public function snapshot(): array
    {
        return [

            'id' => (string) $this->id,

            'recipient_id' => $this->recipientId,

            'title' => $this->title,

            'message' => $this->message,

            'status' => $this->status->value,
        ];
    }
}
