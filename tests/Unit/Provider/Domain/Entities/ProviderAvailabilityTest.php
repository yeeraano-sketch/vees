<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Provider\Domain\Entities;

use Vees\Core\Provider\Domain\Entities\ProviderAvailability;
use Vees\Core\Provider\Domain\Enums\AvailabilityStatus;
use PHPUnit\Framework\TestCase;

class ProviderAvailabilityTest extends TestCase
{
    public function test_create(): void
    {
        $a = new ProviderAvailability(AvailabilityStatus::Offline);
        $this->assertSame(AvailabilityStatus::Offline, $a->status());
        $this->assertFalse($a->isAvailable());
        $this->assertTrue($a->isOffline());
    }

    public function test_change_to_available(): void
    {
        $a = new ProviderAvailability(AvailabilityStatus::Offline);
        $a->changeStatus(AvailabilityStatus::Available);
        $this->assertTrue($a->isAvailable());
    }

    public function test_change_to_busy(): void
    {
        $a = new ProviderAvailability(AvailabilityStatus::Available);
        $a->changeStatus(AvailabilityStatus::Busy);
        $this->assertTrue($a->isBusy());
    }
}
