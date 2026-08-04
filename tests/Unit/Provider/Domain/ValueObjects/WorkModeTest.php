<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Provider\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use Vees\Core\Provider\Domain\ValueObjects\WorkMode;

class WorkModeTest extends TestCase
{
    public function test_taxi(): void
    {
        $this->assertSame('taxi', WorkMode::Taxi->value);
    }

    public function test_delivery(): void
    {
        $this->assertSame('delivery', WorkMode::Delivery->value);
    }

    public function test_taxi_and_delivery(): void
    {
        $this->assertSame('taxi_and_delivery', WorkMode::TaxiAndDelivery->value);
    }

    public function test_supports_taxi(): void
    {
        $this->assertTrue(WorkMode::Taxi->supportsTaxi());
        $this->assertTrue(WorkMode::TaxiAndDelivery->supportsTaxi());
        $this->assertFalse(WorkMode::Delivery->supportsTaxi());
    }

    public function test_supports_delivery(): void
    {
        $this->assertTrue(WorkMode::Delivery->supportsDelivery());
        $this->assertTrue(WorkMode::TaxiAndDelivery->supportsDelivery());
        $this->assertFalse(WorkMode::Taxi->supportsDelivery());
    }

    public function test_cases(): void
    {
        $this->assertCount(3, WorkMode::cases());
    }
}
