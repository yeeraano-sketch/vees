<?php

declare(strict_types=1);

namespace Vees\Core\Policy\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Vees\Core\Policy\Application\Services\PolicyEngine;
use Vees\Core\Policy\Domain\Policies\ProviderEligibilityPolicy;
use Vees\Core\Provider\Domain\Specifications\CanAcceptSessionSpecification;
use Vees\Core\Provider\Domain\Specifications\IsEligibleProviderSpecification;

final class PolicyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ProviderEligibilityPolicy::class, function ($app) {
            return new ProviderEligibilityPolicy([
                $app->make(CanAcceptSessionSpecification::class),
                $app->make(IsEligibleProviderSpecification::class),
            ]);
        });

        $this->app->singleton(PolicyEngine::class, function ($app) {
            return new PolicyEngine(
                $app->make(ProviderEligibilityPolicy::class),
            );
        });
    }

    public function boot(): void
    {
    }
}
