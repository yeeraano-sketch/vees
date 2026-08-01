<?php

declare(strict_types=1);

namespace App\Matching\Domain\Aggregates\Matching;

use App\Matching\Domain\Enums\MatchingStatus;
use App\Matching\Domain\Events\MatchingCreated;
use App\Matching\Domain\Events\ProviderMatched;
use App\Matching\Domain\Exceptions\NoEligibleProviderFound;
use App\Matching\Domain\ValueObjects\MatchingId;
use App\SharedKernel\Domain\AggregateRoot;

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
            new MatchingCreated($id)
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
            new ProviderMatched($this->id)
        );
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
