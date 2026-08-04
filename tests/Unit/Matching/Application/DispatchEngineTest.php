<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Matching\Application;

use PHPUnit\Framework\TestCase;
use Vees\Core\Matching\Application\Commands\DispatchSessionCommand;
use Vees\Core\Matching\Application\Services\DispatchEngine;
use Vees\Core\Matching\Domain\Aggregates\Matching\Candidate;
use Vees\Core\Matching\Domain\Aggregates\Matching\MatchingFactory;
use Vees\Core\Matching\Domain\Contracts\CandidateProvider;
use Vees\Core\Matching\Domain\Contracts\MatchingRepository;

final class DispatchEngineTest extends TestCase
{
    private CandidateProvider $candidateProvider;

    private MatchingRepository $repository;

    private DispatchEngine $engine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->candidateProvider = $this->createMock(CandidateProvider::class);
        $this->repository = $this->createMock(MatchingRepository::class);
        $this->engine = new DispatchEngine(
            $this->candidateProvider,
            new MatchingFactory,
            $this->repository,
        );
    }

    public function test_dispatch_selects_best_candidate(): void
    {
        $command = new DispatchSessionCommand(
            sessionId: 'session-1',
            serviceType: 1,
            cityId: 'city-1',
        );

        $candidates = [
            new Candidate(providerId: 'p-1', distance: 5.0, rating: 4.5, waitTimeSeconds: 120, score: 80.0),
            new Candidate(providerId: 'p-2', distance: 2.0, rating: 4.9, waitTimeSeconds: 60, score: 95.0),
            new Candidate(providerId: 'p-3', distance: 8.0, rating: 4.0, waitTimeSeconds: 300, score: 60.0),
        ];

        $this->candidateProvider
            ->expects($this->once())
            ->method('findCandidates')
            ->with(1, 'city-1')
            ->willReturn($candidates);

        $this->repository
            ->expects($this->once())
            ->method('save');

        $result = $this->engine->dispatch($command);

        $this->assertEquals('p-2', $result); // Best candidate (highest score)
    }

    public function test_dispatch_throws_when_no_candidates(): void
    {
        $command = new DispatchSessionCommand(
            sessionId: 'session-1',
            serviceType: 1,
            cityId: 'city-1',
        );

        $this->candidateProvider
            ->expects($this->once())
            ->method('findCandidates')
            ->willReturn([]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No eligible providers found.');

        $this->engine->dispatch($command);
    }
}
