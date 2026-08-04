<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Session\Application;

use PHPUnit\Framework\TestCase;
use Vees\Core\Provider\Domain\Specifications\CanAcceptSessionSpecification;
use Vees\Core\Session\Application\Commands\AcceptSessionCommand;
use Vees\Core\Session\Application\Commands\CancelSessionCommand;
use Vees\Core\Session\Application\Commands\CompleteSessionCommand;
use Vees\Core\Session\Application\Commands\CreateSessionCommand;
use Vees\Core\Session\Application\Services\SessionEngine;
use Vees\Core\Session\Domain\Aggregates\Session\Session;
use Vees\Core\Session\Domain\Aggregates\Session\SessionFactory;
use Vees\Core\Session\Domain\Contracts\SessionRepository;
use Vees\Core\Session\Domain\Enums\SessionStatus;
use Vees\Core\Session\Domain\ValueObjects\SessionId;

final class SessionEngineTest extends TestCase
{
    private SessionRepository $repository;

    private SessionEngine $engine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(SessionRepository::class);
        $this->engine = new SessionEngine(
            $this->repository,
            new SessionFactory,
            new CanAcceptSessionSpecification,
        );
    }

    private function createTestSession(string $id): Session
    {
        return Session::create(
            id: SessionId::fromString($id),
            providerId: 'provider-1',
            customerId: 'customer-1',
            matchingId: 'match-1',
            subscriptionId: 'sub-1',
        );
    }

    public function test_create_session(): void
    {
        $command = new CreateSessionCommand(
            id: 'test-id',
            providerId: 'provider-1',
            customerId: 'customer-1',
            matchingId: 'match-1',
            subscriptionId: 'sub-1',
        );

        $this->repository
            ->expects($this->once())
            ->method('save');

        $session = $this->engine->create($command);

        $this->assertInstanceOf(Session::class, $session);
        $this->assertEquals(SessionStatus::Pending, $session->status());
    }

    public function test_accept_session(): void
    {
        $session = $this->createTestSession('test-id');

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($this->callback(fn (SessionId $id) => $id->value() === 'test-id'))
            ->willReturn($session);

        $this->repository
            ->expects($this->once())
            ->method('countActiveSessionsForProvider')
            ->with('provider-1')
            ->willReturn(0);

        $this->repository
            ->expects($this->once())
            ->method('save');

        $command = new AcceptSessionCommand(sessionId: 'test-id');
        $result = $this->engine->accept($command);

        $this->assertEquals(SessionStatus::Accepted, $result->status());
    }

    public function test_complete_session(): void
    {
        $session = $this->createTestSession('test-id');
        $session->accept();
        $session->start();

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($session);

        $this->repository
            ->expects($this->once())
            ->method('save');

        $command = new CompleteSessionCommand(sessionId: 'test-id');
        $result = $this->engine->complete($command);

        $this->assertEquals(SessionStatus::Completed, $result->status());
    }

    public function test_cancel_session(): void
    {
        $session = $this->createTestSession('test-id');

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($session);

        $this->repository
            ->expects($this->once())
            ->method('save');

        $command = new CancelSessionCommand(sessionId: 'test-id');
        $result = $this->engine->cancel($command);

        $this->assertEquals(SessionStatus::Cancelled, $result->status());
    }
}
