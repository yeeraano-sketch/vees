<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Domain\Contracts;

use Vees\Core\Matching\Domain\Aggregates\Matching\Candidate;

interface CandidateProvider
{
    /**
     * @param int $serviceType
     * @param string $cityId
     * @return Candidate[]
     */
    public function findCandidates(int $serviceType, string $cityId): array;
}
