<?php

declare(strict_types=1);

namespace Vees\Core\Identity\Domain\Events;

use Vees\Core\SharedKernel\Domain\Events\AbstractDomainEvent;

final class UserDeactivated extends AbstractDomainEvent
{
    public function __construct(
        string $userId,
        ?string $correlationId = null,
        ?string $causationId = null
    ) {
        parent::__construct($userId, $correlationId, $causationId);
    }

    public function entityType(): string
    {
        return 'User';
    }

    public function producer(): string
    {
        return 'IdentityModule';
    }

    public function payload(): array
    {
        return ['userId' => $this->entityId()];
    }
}
