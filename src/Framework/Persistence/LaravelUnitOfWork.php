<?php

declare(strict_types=1);

namespace Vees\Core\Framework\Persistence;

use Illuminate\Support\Facades\DB;
use Vees\Core\SharedKernel\Application\Contracts\UnitOfWork;
use Vees\Core\SharedKernel\Domain\Result;

final class LaravelUnitOfWork implements UnitOfWork
{
    public function begin(): void
    {
        DB::beginTransaction();
    }

    public function commit(): Result
    {
        DB::commit();

        return Result::success();
    }

    public function rollback(): void
    {
        DB::rollBack();
    }
}
