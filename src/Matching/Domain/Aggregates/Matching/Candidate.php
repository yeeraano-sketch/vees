<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Domain\Aggregates\Matching;

final readonly class Candidate
{
    public function __construct(
        public string $providerId,
        public float $distance,
        public float $rating,
        public int $waitTimeSeconds,
        public float $score = 0.0,
    ) {}
}
