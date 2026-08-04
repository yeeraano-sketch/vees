<?php

declare(strict_types=1);

namespace Vees\Core\Framework\Persistence;

use Vees\Core\SharedKernel\Domain\Result;
use Illuminate\Support\Facades\DB;

final class LaravelUnitOfWork implements UnitOfWork
{
    public function begin(): void
    {
        DB::beginTransaction();
    }

    public function commit(): Result
    {
        try {

            DB::commit();

            return Result::success();

        } catch (\Throwable $exception) {

            DB::rollBack();

            throw $exception;
        }
    }

    public function rollback(): void
    {
        DB::rollBack();
    }
}
