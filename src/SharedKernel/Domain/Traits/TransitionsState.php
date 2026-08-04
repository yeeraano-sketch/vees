<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain\Traits;

use Vees\Core\SharedKernel\Domain\Exceptions\InvalidStateTransitionException;

trait TransitionsState
{
    /**
     * @param array<string, array<string>> $allowedTransitions
     */
    protected function transitionTo(
        string $newState,
        string $currentState,
        array $allowedTransitions,
    ): string {
        if ($currentState === $newState) {
            return $currentState;
        }

        $allowed = $allowedTransitions[$currentState] ?? [];

        if (!in_array($newState, $allowed, true)) {
            throw new InvalidStateTransitionException($currentState, $newState);
        }

        return $newState;
    }
}
