<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Application\Services;

use Vees\Core\Matching\Application\Commands\DispatchSessionCommand;
use Vees\Core\Matching\Domain\Aggregates\Matching\Candidate;
use Vees\Core\Matching\Domain\Aggregates\Matching\MatchingFactory;
use Vees\Core\Matching\Domain\Contracts\CandidateProvider;
use Vees\Core\Matching\Domain\Contracts\MatchingRepository;
use Vees\Core\Matching\Domain\ValueObjects\MatchingId;
use Ramsey\Uuid\Uuid;

final readonly class DispatchEngine
{
    public function __construct(
        private CandidateProvider $candidateProvider,
        private MatchingFactory $factory,
        private MatchingRepository $repository,
    ) {
    }

    public function dispatch(DispatchSessionCommand $command): string
    {
        $candidates = $this->candidateProvider->findCandidates(
            $command->serviceType,
            $command->cityId,
        );

        if (empty($candidates)) {
            throw new \RuntimeException('No eligible providers found.');
        }

        $best = $this->selectBestCandidate($candidates);

        $matchingId = MatchingId::fromString(Uuid::uuid4()->toString());

        $matching = $this->factory->create(
            id: $matchingId,
            sessionId: $command->sessionId,
        );

        $matching->match($best->providerId);

        $this->repository->save($matching);

        return $best->providerId;
    }

    /**
     * @param Candidate[] $candidates
     */
    private function selectBestCandidate(array $candidates): Candidate
    {
        usort($candidates, function (Candidate $a, Candidate $b) {
            return $b->score <=> $a->score;
        });

        return $candidates[0];
    }
}
