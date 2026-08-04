<?php

declare(strict_types=1);

namespace Vees\Core\Subscription\Domain\ValueObjects;

use DateTimeImmutable;

final readonly class SubscriptionPeriod
{
    public function __construct(
        private DateTimeImmutable $startsAt,
        private DateTimeImmutable $endsAt,
    ) {
    }

    public function startsAt(): DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function endsAt(): DateTimeImmutable
    {
        return $this->endsAt;
    }

    public function isActive(
        DateTimeImmutable $now,
    ): bool {

        return $now >= $this->startsAt
            && $now <= $this->endsAt;
    }

    public function toArray(): array
    {
        return [
            'starts_at' => $this->startsAt->format(DATE_ATOM),
            'ends_at' => $this->endsAt->format(DATE_ATOM),
        ];
    }
}
