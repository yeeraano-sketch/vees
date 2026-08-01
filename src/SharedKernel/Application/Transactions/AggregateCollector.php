<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Transactions;

use App\SharedKernel\Domain\AggregateRoot;

final class AggregateCollector
{
    /**
     * @var array<string,AggregateRoot>
     */
    private array $aggregates = [];

    public function add(
        AggregateRoot $aggregate,
    ): void {

        $this->aggregates[
            spl_object_hash($aggregate)
        ] = $aggregate;
    }

    /**
     * @return list<AggregateRoot>
     */
    public function all(): array
    {
        return array_values($this->aggregates);
    }

    public function clear(): void
    {
        $this->aggregates = [];
    }
}
