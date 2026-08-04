<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Infrastructure\Persistence;

use Vees\Core\Matching\Domain\Aggregates\Matching\Candidate;
use Vees\Core\Matching\Domain\Contracts\CandidateProvider;

final class InMemoryCandidateProvider implements CandidateProvider
{
    public function findCandidates(int $serviceType, string $cityId): array
    {
        // منطق مؤقت للاختبار فقط
        return [
            new Candidate(
                providerId: 'provider-1',
                distance: 1.5,
                rating: 4.8,
                waitTimeSeconds: 120,
                score: 95.0,
            ),
            new Candidate(
                providerId: 'provider-2',
                distance: 3.2,
                rating: 4.5,
                waitTimeSeconds: 300,
                score: 78.0,
            ),
        ];
    }
}
