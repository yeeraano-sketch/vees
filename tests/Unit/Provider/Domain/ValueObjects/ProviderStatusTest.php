<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Provider\Domain\ValueObjects;

use Vees\Core\Provider\Domain\ValueObjects\ProviderStatus;
use PHPUnit\Framework\TestCase;

class ProviderStatusTest extends TestCase
{
    public function test_pending(): void
    {
        $this->assertSame('pending', ProviderStatus::Pending->value);
    }

    public function test_active(): void
    {
        $this->assertSame('active', ProviderStatus::Active->value);
    }

    public function test_suspended(): void
    {
        $this->assertSame('suspended', ProviderStatus::Suspended->value);
    }

    public function test_blocked(): void
    {
        $this->assertSame('blocked', ProviderStatus::Blocked->value);
    }

    public function test_cases(): void
    {
        $this->assertCount(4, ProviderStatus::cases());
    }
}
