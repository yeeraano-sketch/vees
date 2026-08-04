<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Provider\Domain\Entities;

use Vees\Core\Provider\Domain\Entities\ProviderVerification;
use Vees\Core\Provider\Domain\Enums\VerificationStatus;
use PHPUnit\Framework\TestCase;

class ProviderVerificationTest extends TestCase
{
    public function test_default_is_pending(): void
    {
        $v = new ProviderVerification();
        $this->assertSame(VerificationStatus::Pending, $v->status());
    }

    public function test_verify(): void
    {
        $v = new ProviderVerification();
        $v->verify();
        $this->assertTrue($v->isVerified());
    }

    public function test_reject(): void
    {
        $v = new ProviderVerification(VerificationStatus::Verified);
        $v->reject();
        $this->assertSame(VerificationStatus::Rejected, $v->status());
    }

    public function test_reset(): void
    {
        $v = new ProviderVerification(VerificationStatus::Rejected);
        $v->reset();
        $this->assertSame(VerificationStatus::Pending, $v->status());
    }
}
