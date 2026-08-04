<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Application\Contracts;

use Vees\Core\SharedKernel\Domain\Result;

interface UnitOfWork
{
    public function begin(): void;

    public function commit(): Result;

    public function rollback(): void;
}
