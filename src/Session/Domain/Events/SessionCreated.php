<?php

declare(strict_types=1);

namespace App\Session\Domain\Events;

use App\Session\Domain\ValueObjects\SessionId;
use App\SharedKernel\Domain\Events\AbstractDomainEvent;

final class SessionCreated extends AbstractDomainEvent
{
    public function __construct(
        private readonly SessionId $sessionId,
    ) {
        parent::__construct();
    }

    public function aggregateId(): string
    {
        return (string) $this->sessionId;
    }

    public function payload(): array
    {
        return [
            'sessionId' => (string) $this->sessionId,
        ];
    }
}
