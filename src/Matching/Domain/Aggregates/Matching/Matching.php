<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Domain\Aggregates\Matching;

use Vees\Core\Matching\Domain\Enums\MatchingStatus;
use Vees\Core\Matching\Domain\Events\MatchingCreated;
use Vees\Core\Matching\Domain\Events\ProviderMatched;
use Vees\Core\Matching\Domain\Exceptions\NoEligibleProviderFound;
use Vees\Core\Matching\Domain\ValueObjects\MatchingId;
use Vees\Core\SharedKernel\Domain\AggregateRoot;

final class Matching extends AggregateRoot
{
    private function __construct(
        private MatchingId $id,
        private string $sessionId,
        private ?string $providerId,
        private MatchingStatus $status,
    ) {
    }

    public static function create(
        MatchingId $id,
        string $sessionId,
    ): self {

        $matching = new self(
            id: $id,
            sessionId: $sessionId,
            providerId: null,
            status: MatchingStatus::Pending,
        );

        $matching->recordEvent(
            new MatchingCreated($id->value())
        );

        return $matching;
    }

    public function match(
        string $providerId,
    ): void {

        if ($providerId === '') {
            throw new NoEligibleProviderFound();
        }

        $this->providerId = $providerId;
        $this->status = MatchingStatus::Matched;

        $this->recordEvent(
            new ProviderMatched($this->id->value())
        );
    }

    protected function identity(): mixed
    {
        return $this->id;
    }

    public function id(): MatchingId
    {
        return $this->id;
    }

    public function providerId(): ?string
    {
        return $this->providerId;
    }

    public function sessionId(): string
    {
        return $this->sessionId;
    }

    public function status(): MatchingStatus
    {
        return $this->status;
    }

    public function snapshot(): array
    {
        return [
            'id' => (string) $this->id,
            'session_id' => $this->sessionId,
            'provider_id' => $this->providerId,
            'status' => $this->status->value,
        ];
    }
}
