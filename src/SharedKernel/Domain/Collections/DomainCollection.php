<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Collections;

use Countable;
use IteratorAggregate;
use ArrayIterator;
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
