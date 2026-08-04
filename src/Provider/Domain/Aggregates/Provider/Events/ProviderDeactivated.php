<?php
declare(strict_types=1);
namespace Vees\Core\Provider\Domain\Aggregates\Provider\Events;
use Vees\Core\SharedKernel\Domain\Events\AbstractDomainEvent;
final class ProviderDeactivated extends AbstractDomainEvent
{
    public function __construct(string $providerId, ?string $correlationId = null, ?string $causationId = null) {
        parent::__construct($providerId, $correlationId, $causationId);
    }
    public function entityType(): string { return 'Provider'; }
    public function producer(): string { return 'ProviderModule'; }
    public function payload(): array { return ['providerId' => $this->entityId()]; }
}
