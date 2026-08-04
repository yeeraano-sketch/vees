<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Session\Domain;

use PHPUnit\Framework\TestCase;
use Vees\Core\Session\Domain\Aggregates\Session\Session;
use Vees\Core\Session\Domain\Exceptions\InvalidSessionState;
use Vees\Core\Session\Domain\ValueObjects\SessionId;
use Vees\Core\SharedKernel\Domain\Exceptions\DomainException;
use Vees\Core\SharedKernel\Domain\Exceptions\InvalidStateTransitionException;

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

    public function test_cannot_reassign_provider_to_session(): void
    {
        $this->expectException(InvalidSessionState::class);
        $this->expectExceptionMessage('Session is already assigned to a provider. Cannot reassign.');

        $this->session->assignProvider('provider-2');
    }

    public function test_cannot_start_session_before_accepted(): void
    {
        $this->expectException(InvalidStateTransitionException::class);
        $this->expectExceptionMessage('Invalid state transition from "pending" to "started".');

        $this->session->start();
    }

    public function test_cannot_complete_session_before_started(): void
    {
        $this->session->accept();

        $this->expectException(InvalidStateTransitionException::class);
        $this->expectExceptionMessage('Invalid state transition from "accepted" to "completed".');

        $this->session->complete();
    }
}
