<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Contracts;

use App\SharedKernel\Domain\Result;

interface UnitOfWork
{
    public function begin(): void;

    public function commit(): Result;

    public function rollback(): void;
}
