<?php

declare(strict_types=1);

namespace Vees\Core\Scheduler\Application\Services;

use DateTimeImmutable;

final class SchedulerEngine
{
    /** @var array<string, callable> */
    private array $tasks = [];

    public function schedule(string $taskId, DateTimeImmutable $executeAt, callable $task): void
    {
        $this->tasks[$taskId] = $task;
    }

    public function cancel(string $taskId): void
    {
        unset($this->tasks[$taskId]);
    }

    public function dueTasks(): array
    {
        return $this->tasks;
    }
}
