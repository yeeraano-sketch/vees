<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Domain\ValueObjects;

final readonly class Money
{
    public function __construct(
        private int $amount,
        private string $currency,
    ) {}

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}
