<?php

declare(strict_types=1);

namespace App\Session\Domain\Aggregates\Session;

use App\Session\Domain\Enums\SessionStatus;
use App\Session\Domain\Events\SessionCompleted;
use App\Session\Domain\Events\SessionCreated;
use App\Session\Domain\Events\SessionStarted;
use App\Session\Domain\Exceptions\InvalidSessionState;
use App\Session\Domain\ValueObjects\SessionId;
use App\SharedKernel\Domain\AggregateRoot;

final class Session extends AggregateRoot
{
    private function __construct(
        private SessionId $id,
        private string $providerId,
        private string $customerId,
        private string $matchingId,
        private string $subscriptionId,
        private SessionStatus $status,
    ) {
    }

    public static function create(
        SessionId $id,
        string $providerId,
        string $customerId,
        string $matchingId,
        string $subscriptionId,
    ): self {

        $session = new self(
            id: $id,
            providerId: $providerId,
            customerId: $customerId,
            matchingId: $matchingId,
            subscriptionId: $subscriptionId,
            status: SessionStatus::Pending,
        );

        $session->recordEvent(
            new SessionCreated($id)
        );

        return $session;
    }

    public function start(): void
    {
        if ($this->status !== SessionStatus::Accepted) {
            throw new InvalidSessionState(
                'Session cannot be started.'
            );
        }

        $this->status = SessionStatus::Started;

        $this->recordEvent(
            new SessionStarted($this->id)
        );
    }

    public function complete(): void
    {
        if ($this->status !== SessionStatus::Started) {
            throw new InvalidSessionState(
                'Session cannot be completed.'
            );
        }

        $this->status = SessionStatus::Completed;

        $this->recordEvent(
            new SessionCompleted($this->id)
        );
    }

    public function accept(): void
    {
        if ($this->status !== SessionStatus::Pending) {
            throw new InvalidSessionState(
                'Session cannot be accepted.'
            );
        }

        $this->status = SessionStatus::Accepted;
    }

    public function cancel(): void
    {
        if (
            $this->status === SessionStatus::Completed
        ) {
            throw new InvalidSessionState(
                'Completed session cannot be cancelled.'
            );
        }

        $this->status = SessionStatus::Cancelled;
    }

    public function id(): SessionId
    {
        return $this->id;
    }

    public function status(): SessionStatus
    {
        return $this->status;
    }

    public function snapshot(): array
    {
        return [

            'id' => (string) $this->id,

            'provider_id' => $this->providerId,

            'customer_id' => $this->customerId,

            'matching_id' => $this->matchingId,

            'subscription_id' => $this->subscriptionId,

            'status' => $this->status->value,
        ];
    }
}
