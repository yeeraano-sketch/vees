<?php
declare(strict_types=1);
namespace Vees\Core\Session\Domain\Events;
use Vees\Core\SharedKernel\Domain\Events\AbstractDomainEvent;
final class SessionCompleted extends AbstractDomainEvent
{
    public function __construct(string $sessionId, ?string $correlationId = null, ?string $causationId = null) {
        parent::__construct($sessionId, $correlationId, $causationId);
    }
    public function entityType(): string { return 'Session'; }
    public function producer(): string { return 'SessionEngine'; }
    public function payload(): array { return ['sessionId' => $this->entityId()]; }
}
