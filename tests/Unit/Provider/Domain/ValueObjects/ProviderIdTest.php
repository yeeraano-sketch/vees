<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Provider\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use Vees\Core\Provider\Domain\ValueObjects\ProviderId;

class ProviderIdTest extends TestCase
{
    public function test_create_valid_provider_id(): void
    {
        $id = new ProviderId('550e8400-e29b-41d4-a716-446655440000');
        $this->assertSame('550e8400-e29b-41d4-a716-446655440000', $id->value());
        $this->assertSame('550e8400-e29b-41d4-a716-446655440000', $id->toString());
    }

    public function test_empty_id_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new ProviderId('');
    }

    public function test_equals_same_value(): void
    {
        $id1 = new ProviderId('550e8400-e29b-41d4-a716-446655440000');
        $id2 = new ProviderId('550e8400-e29b-41d4-a716-446655440000');
        $this->assertTrue($id1->equals($id2));
    }

    public function test_equals_different_value(): void
    {
        $id1 = new ProviderId('550e8400-e29b-41d4-a716-446655440000');
        $id2 = new ProviderId('660e8400-e29b-41d4-a716-446655440000');
        $this->assertFalse($id1->equals($id2));
    }

    public function test_to_array(): void
    {
        $id = new ProviderId('test-id');
        $this->assertSame(['value' => 'test-id'], $id->toArray());
    }
}
