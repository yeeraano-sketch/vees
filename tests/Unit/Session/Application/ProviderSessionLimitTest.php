<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Session\Application;

use PHPUnit\Framework\TestCase;
use Vees\Core\Provider\Domain\Specifications\CanAcceptSessionSpecification;
use Vees\Core\Session\Application\Commands\AcceptSessionCommand;
use Vees\Core\Session\Application\Services\SessionEngine;
use Vees\Core\Session\Domain\Aggregates\Session\Session;
use Vees\Core\Session\Domain\Aggregates\Session\SessionFactory;
use Vees\Core\Session\Domain\Contracts\SessionRepository;
use Vees\Core\Session\Domain\ValueObjects\SessionId;

final class ProviderSessionLimitTest extends TestCase
{
    private SessionRepository $repository;
    private SessionEngine $engine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(SessionRepository::class);
        $this->engine = new SessionEngine(
            $this->repository,
            new SessionFactory(),
            new CanAcceptSessionSpecification(),
        );
    }

    public function test_provider_with_active_session_cannot_accept_another(): void
    {
        $session = Session::create(
            id: SessionId::fromString('session-1'),
            providerId: 'provider-1',
            customerId: 'customer-1',
            matchingId: 'match-1',
            subscriptionId: 'sub-1',
        );

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($session);

        $this->repository
            ->expects($this->once())
            ->method('countActiveSessionsForProvider')
            ->with('provider-1')
            ->willReturn(1);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Provider is not eligible to accept new sessions.');

        $command = new AcceptSessionCommand(sessionId: 'session-1');
        $this->engine->accept($command);
    }
}
