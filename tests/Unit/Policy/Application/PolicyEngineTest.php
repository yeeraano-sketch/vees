<?php

declare(strict_types=1);

namespace Vees\Core\Tests\Unit\Policy\Application;

use PHPUnit\Framework\TestCase;
use Vees\Core\Policy\Application\Services\PolicyEngine;
use Vees\Core\Policy\Domain\Policies\ProviderEligibilityPolicy;
use Vees\Core\SharedKernel\Domain\Contracts\Specification;

final class PolicyEngineTest extends TestCase
{
    public function test_eligible_provider_passes_policy(): void
    {
        $alwaysPass = $this->createMock(Specification::class);
        $alwaysPass->method('isSatisfiedBy')->willReturn(true);

        $policy = new ProviderEligibilityPolicy([$alwaysPass]);
        $engine = new PolicyEngine($policy);

        $result = $engine->evaluate(['id' => 'provider-1']);

        $this->assertEmpty($result);
    }

    public function test_ineligible_provider_triggers_suspend(): void
    {
        $alwaysFail = $this->createMock(Specification::class);
        $alwaysFail->method('isSatisfiedBy')->willReturn(false);

        $policy = new ProviderEligibilityPolicy([$alwaysFail]);
        $engine = new PolicyEngine($policy);

        $result = $engine->evaluate(['id' => 'provider-1']);

        $this->assertContains('suspend', $result);
    }
}
