<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Domain\Events;

use Vees\Core\SharedKernel\Domain\Events\AbstractDomainEvent;

final class MatchingCreated extends AbstractDomainEvent
{
    public function __construct(string $matchingId, ?string $correlationId = null, ?string $causationId = null)
    {
        parent::__construct($matchingId, $correlationId, $causationId);
    }

    public function entityType(): string
    {
        return 'Matching';
    }

    public function producer(): string
    {
        return 'DispatchEngine';
    }

    public function payload(): array
    {
        return ['matchingId' => $this->entityId()];
    }
}
