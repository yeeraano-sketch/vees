<?php

declare(strict_types=1);

namespace Vees\Core\SharedKernel\Domain\Collections;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

abstract class DomainCollection implements Countable, IteratorAggregate
{
    protected array $items = [];

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }
}
