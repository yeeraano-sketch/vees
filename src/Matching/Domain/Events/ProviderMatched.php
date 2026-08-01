<?php

declare(strict_types=1);

namespace App\Matching\Domain\Events;

use App\Matching\Domain\ValueObjects\MatchingId;
use App\SharedKernel\Domain\Events\AbstractDomainEvent;

final class ProviderMatched extends AbstractDomainEvent
{
    public function __construct(
        private readonly MatchingId $matchingId,
    ) {
        parent::__construct();
    }

    public function aggregateId(): string
    {
        return (string) $this->matchingId;
    }

    public function payload(): array
    {
        return [
            'matchingId' => (string) $this->matchingId,
        ];
    }
}
