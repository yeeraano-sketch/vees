<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Provider\Domain\Specifications;

use PHPUnit\Framework\TestCase;
use Vees\Core\Provider\Domain\Contracts\AvailabilityInterface;
use Vees\Core\Provider\Domain\Enums\AvailabilityStatus;
use Vees\Core\Provider\Domain\Specifications\CanAcceptSessionSpecification;

final class CanAcceptSessionSpecificationTest extends TestCase
{
    private function createAvailabilityMock(AvailabilityStatus $status): AvailabilityInterface
    {
        $availability = $this->createMock(AvailabilityInterface::class);
        $availability->method('status')->willReturn($status);

        return $availability;
    }

    public function test_provider_with_active_session_cannot_accept_new_session(): void
    {
        $specification = new CanAcceptSessionSpecification;
        $availability = $this->createAvailabilityMock(AvailabilityStatus::Available);

        $result = $specification->isSatisfiedBy($availability, 1);
        $this->assertFalse($result);
    }

    public function test_provider_without_active_session_can_accept_session(): void
    {
        $specification = new CanAcceptSessionSpecification;
        $availability = $this->createAvailabilityMock(AvailabilityStatus::Available);

        $result = $specification->isSatisfiedBy($availability, 0);
        $this->assertTrue($result);
    }

    public function test_provider_offline_cannot_accept_session(): void
    {
        $specification = new CanAcceptSessionSpecification;
        $availability = $this->createAvailabilityMock(AvailabilityStatus::Offline);

        $result = $specification->isSatisfiedBy($availability, 0);
        $this->assertFalse($result);
    }
}
