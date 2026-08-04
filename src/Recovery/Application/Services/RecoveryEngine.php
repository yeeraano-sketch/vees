<?php

declare(strict_types=1);

namespace Vees\Core\Recovery\Application\Services;

use Vees\Core\Session\Domain\Contracts\SessionRepository;
use Vees\Core\Session\Domain\Enums\SessionStatus;
use Vees\Core\Session\Domain\ValueObjects\SessionId;
use Vees\Core\SharedKernel\Application\EventBus\EventBus;

final readonly class RecoveryEngine
{
    public function __construct(
        private SessionRepository $sessionRepository,
        private EventBus $eventBus,
    ) {
    }

    /**
     * Scans for stale sessions and applies recovery actions.
     * This implements the Failure Matrix from the constitution.
     *
     * @return array<string, string> Map of session ID => action taken
     */
    public function recoverStaleSessions(): array
    {
        $actions = [];
        $staleSessions = $this->findStaleSessions();

        foreach ($staleSessions as $session) {
            $action = $this->determineAction($session->status());

            match ($action) {
                'cancel' => $session->cancel(),
                default => null,
            };

            $this->sessionRepository->save($session);
            $actions[(string) $session->id()] = $action;

            // Publish recovery event
            foreach ($session->releaseEvents() as $event) {
                $this->eventBus->dispatch($event);
            }
        }

        return $actions;
    }

    /**
     * @return \Vees\Core\Session\Domain\Aggregates\Session\Session[]
     */
    private function findStaleSessions(): array
    {
        // Placeholder: fetch sessions stuck in non-terminal states for too long
        return [];
    }

    private function determineAction(SessionStatus $status): string
    {
        return match ($status) {
            SessionStatus::Started => 'cancel',
            default => 'ignore',
        };
    }
}
