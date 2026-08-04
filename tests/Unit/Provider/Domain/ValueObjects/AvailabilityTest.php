<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Provider\Domain\ValueObjects;

use Vees\Core\Provider\Domain\ValueObjects\Availability;
use PHPUnit\Framework\TestCase;

class AvailabilityTest extends TestCase
{
    public function test_offline(): void
    {
        $this->assertSame('offline', Availability::Offline->value);
    }

    public function test_available(): void
    {
        $this->assertSame('available', Availability::Available->value);
    }

    public function test_busy(): void
    {
        $this->assertSame('busy', Availability::Busy->value);
    }

    public function test_cases(): void
    {
        $cases = Availability::cases();
        $this->assertCount(3, $cases);
    }
}
