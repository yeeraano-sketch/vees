<?php

declare(strict_types=1);

namespace App\Framework\Persistence;

use App\SharedKernel\Domain\Result;

interface UnitOfWork
{
    public function begin(): void;

    public function commit(): Result;

    public function rollback(): void;
}
