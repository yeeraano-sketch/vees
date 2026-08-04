<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Provider\Domain\ValueObjects;

use Vees\Core\Provider\Domain\ValueObjects\PhoneNumber;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    public function test_create_valid_phone(): void
    {
        $phone = new PhoneNumber('+966501234567');
        $this->assertSame('+966501234567', $phone->value());
    }

    public function test_empty_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new PhoneNumber('');
    }

    public function test_spaces_only_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new PhoneNumber('  ');
    }

    public function test_equals(): void
    {
        $p1 = new PhoneNumber('+966501234567');
        $p2 = new PhoneNumber('+966501234567');
        $this->assertTrue($p1->equals($p2));
    }
}
