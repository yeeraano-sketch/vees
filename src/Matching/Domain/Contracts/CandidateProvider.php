<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Domain\Contracts;

use Vees\Core\Matching\Domain\Aggregates\Matching\Candidate;

interface CandidateProvider
{
    /**
     * @return Candidate[]
     */
    public function findCandidates(int $serviceType, string $cityId): array;
}
