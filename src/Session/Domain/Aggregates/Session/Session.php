<?php

declare(strict_types=1);

namespace Vees\Core\Session\Domain\Aggregates\Session;

use Vees\Core\Provider\Domain\Contracts\AvailabilityInterface;
use Vees\Core\Provider\Domain\Entities\ProviderAvailability;
use Vees\Core\Provider\Domain\Enums\AvailabilityStatus;
use Vees\Core\Session\Domain\Enums\SessionStatus;
use Vees\Core\Session\Domain\Events\SessionCompleted;
use Vees\Core\Session\Domain\Events\SessionCreated;
use Vees\Core\Session\Domain\Events\SessionStarted;
use Vees\Core\Session\Domain\Exceptions\InvalidSessionState;
use Vees\Core\Session\Domain\ValueObjects\SessionId;
use Vees\Core\SharedKernel\Domain\AggregateRoot;
use Vees\Core\SharedKernel\Domain\Traits\TransitionsState;

final class Session extends AggregateRoot
{
    use TransitionsState;

    private const array ALLOWED_TRANSITIONS = [
        SessionStatus::Pending->value => [
            SessionStatus::Accepted->value,
            SessionStatus::Cancelled->value,
        ],
        SessionStatus::Accepted->value => [
            SessionStatus::Started->value,
            SessionStatus::Cancelled->value,
        ],
        SessionStatus::Started->value => [
            SessionStatus::Completed->value,
            SessionStatus::Cancelled->value,
        ],
    ];

    private bool $providerLocked = false;

    private function __construct(
        private SessionId $id,
        private string $providerId,
        private string $customerId,
        private string $matchingId,
        private string $subscriptionId,
        private SessionStatus $status,
    ) {
        if ($providerId !== '') {
            $this->providerLocked = true;
        }
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
            new SessionCreated($id->value())
        );

        return $session;
    }

    public function assignProvider(string $providerId): void
    {
        if ($this->providerLocked) {
            throw new InvalidSessionState(
                'Session is already assigned to a provider. Cannot reassign.'
            );
        }

        if ($providerId === '') {
            throw new InvalidSessionState('Provider ID cannot be empty.');
        }

        $this->providerId = $providerId;
        $this->providerLocked = true;
    }

    public function availability(): AvailabilityInterface
    {
        return new ProviderAvailability(AvailabilityStatus::Available);
    }

    public function accept(): void
    {
        $this->status = SessionStatus::from(
            $this->transitionTo(
                SessionStatus::Accepted->value,
                $this->status->value,
                self::ALLOWED_TRANSITIONS,
            )
        );

        $this->recordEvent(
            new SessionStarted($this->id->value())
        );
    }

    public function start(): void
    {
        $this->status = SessionStatus::from(
            $this->transitionTo(
                SessionStatus::Started->value,
                $this->status->value,
                self::ALLOWED_TRANSITIONS,
            )
        );

        $this->recordEvent(
            new SessionStarted($this->id->value())
        );
    }

    public function complete(): void
    {
        $this->status = SessionStatus::from(
            $this->transitionTo(
                SessionStatus::Completed->value,
                $this->status->value,
                self::ALLOWED_TRANSITIONS,
            )
        );

        $this->recordEvent(
            new SessionCompleted($this->id->value())
        );
    }

    public function cancel(): void
    {
        $this->status = SessionStatus::from(
            $this->transitionTo(
                SessionStatus::Cancelled->value,
                $this->status->value,
                self::ALLOWED_TRANSITIONS,
            )
        );
    }

    protected function identity(): mixed
    {
        return $this->id;
    }

    public function id(): SessionId
    {
        return $this->id;
    }

    public function providerId(): string
    {
        return $this->providerId;
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
