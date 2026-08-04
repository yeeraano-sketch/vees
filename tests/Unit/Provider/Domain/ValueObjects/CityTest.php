<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Provider\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use Vees\Core\Provider\Domain\ValueObjects\City;

class CityTest extends TestCase
{
    public function test_create_valid_city(): void
    {
        $city = new City('Riyadh');
        $this->assertSame('Riyadh', $city->value());
    }

    public function test_empty_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new City('');
    }

    public function test_equals(): void
    {
        $c1 = new City('Jeddah');
        $c2 = new City('Jeddah');
        $this->assertTrue($c1->equals($c2));
    }
}
