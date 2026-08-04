<?php

declare(strict_types=1);

namespace Vees\Core\Session\Application\Services;

use Vees\Core\Session\Application\Commands\CreateSessionCommand;
use Vees\Core\Session\Application\Commands\AcceptSessionCommand;
use Vees\Core\Session\Application\Commands\CompleteSessionCommand;
use Vees\Core\Session\Application\Commands\CancelSessionCommand;
use Vees\Core\Session\Domain\Aggregates\Session\Session;
use Vees\Core\Session\Domain\Aggregates\Session\SessionFactory;
use Vees\Core\Session\Domain\Contracts\SessionRepository;
use Vees\Core\Session\Domain\ValueObjects\SessionId;

final readonly class SessionEngine
{
    public function __construct(
        private SessionRepository $repository,
        private SessionFactory $factory,
    ) {
    }

    public function create(CreateSessionCommand $command): Session
    {
        $session = $this->factory->create(
            id: SessionId::fromString($command->id),
            providerId: $command->providerId,
            customerId: $command->customerId,
            matchingId: $command->matchingId,
            subscriptionId: $command->subscriptionId,
        );

        $this->repository->save($session);

        return $session;
    }

    public function accept(AcceptSessionCommand $command): Session
    {
        $session = $this->repository->findById(SessionId::fromString($command->sessionId));

        if (!$session) {
            throw new \RuntimeException('Session not found.');
        }

        $session->accept();
        $this->repository->save($session);

        return $session;
    }

    public function complete(CompleteSessionCommand $command): Session
    {
        $session = $this->repository->findById(SessionId::fromString($command->sessionId));

        if (!$session) {
            throw new \RuntimeException('Session not found.');
        }

        $session->complete();
        $this->repository->save($session);

        return $session;
    }

    public function cancel(CancelSessionCommand $command): Session
    {
        $session = $this->repository->findById(SessionId::fromString($command->sessionId));

        if (!$session) {
            throw new \RuntimeException('Session not found.');
        }

        $session->cancel();
        $this->repository->save($session);

        return $session;
    }
}
