<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Session\Domain;

use PHPUnit\Framework\TestCase;
use Vees\Core\Session\Domain\Aggregates\Session\Session;
use Vees\Core\Session\Domain\Enums\SessionStatus;
use Vees\Core\Session\Domain\ValueObjects\SessionId;
use Vees\Core\SharedKernel\Domain\Exceptions\DomainException;

final class SessionInvariantsTest extends TestCase
{
    private Session $session;

    protected function setUp(): void
    {
        parent::setUp();
        $this->session = Session::create(
            id: SessionId::fromString('test-id'),
            providerId: 'provider-1',
            customerId: 'customer-1',
            matchingId: 'match-1',
            subscriptionId: 'sub-1',
        );
    }

    public function test_cannot_cancel_completed_session(): void
    {
        $this->session->accept();
        $this->session->start();
        $this->session->complete();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Invalid state transition from "completed" to "cancelled".');

        $this->session->cancel();
    }
}
