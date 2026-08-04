<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain\Exceptions;

final class InvalidStateTransitionException extends DomainException
{
    public function __construct(
        string $currentState,
        string $newState,
    ) {
        parent::__construct(
            sprintf(
                'Invalid state transition from "%s" to "%s".',
                $currentState,
                $newState,
            )
        );
    }
}
