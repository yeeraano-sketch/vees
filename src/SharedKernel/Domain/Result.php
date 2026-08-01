<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain;

/**
 * @template TValue
 */
final readonly class Result
{
    /**
     * @param TValue|null $value
     */
    private function __construct(
        private mixed $value,
        private ?Error $error,
    ) {
    }

    /**
     * @template T
     *
     * @param T $value
     *
     * @return Result<T>
     */
    public static function success(mixed $value = null): self
    {
        return new self($value, null);
    }

    /**
     * @return Result<never>
     */
    public static function failure(Error $error): self
    {
        return new self(null, $error);
    }

    public function isSuccess(): bool
    {
        return $this->error === null;
    }

    public function isFailure(): bool
    {
        return $this->error !== null;
    }

    /**
     * @return TValue|null
     */
    public function value(): mixed
    {
        return $this->value;
    }

    public function error(): ?Error
    {
        return $this->error;
    }
}