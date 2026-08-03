<?php

declare(strict_types=1);

namespace Tests\Unit\Provider\Domain\ValueObjects;

use App\Provider\Domain\ValueObjects\FullName;
use PHPUnit\Framework\TestCase;

class FullNameTest extends TestCase
{
    public function test_create_valid_name(): void
    {
        $name = new FullName('John Doe');
        $this->assertSame('John Doe', $name->value());
    }

    public function test_preserves_whitespace(): void
    {
        $name = new FullName('  John Doe  ');
        $this->assertSame('  John Doe  ', $name->value());
    }

    public function test_only_spaces_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FullName('   ');
    }

    public function test_empty_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FullName('');
    }

    public function test_equals(): void
    {
        $n1 = new FullName('John');
        $n2 = new FullName('John');
        $this->assertTrue($n1->equals($n2));
    }

    public function test_to_array(): void
    {
        $name = new FullName('John');
        $this->assertSame(['value' => 'John'], $name->toArray());
    }
}
