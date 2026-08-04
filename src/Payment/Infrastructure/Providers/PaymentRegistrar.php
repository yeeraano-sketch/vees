<?php

declare(strict_types=1);

namespace Vees\Core\Payment\Infrastructure\Providers;

use Illuminate\Contracts\Foundation\Application;

use Vees\Core\Payment\Domain\Contracts\PaymentRepository;
use Vees\Core\Payment\Domain\Aggregates\Payment\PaymentFactory;

use Vees\Core\Payment\Infrastructure\Persistence\Eloquent\Assemblers\PaymentPersistenceAssembler;
use Vees\Core\Payment\Infrastructure\Persistence\Eloquent\Mappers\PaymentMapper;
use Vees\Core\Payment\Infrastructure\Persistence\Eloquent\Repositories\EloquentPaymentRepository;

final readonly class PaymentRegistrar
{
    public function __construct(
        private Application $app,
    ) {
    }

    public function register(): void
    {
        $this->app->singleton(
            PaymentMapper::class,
        );

        $this->app->singleton(
            PaymentPersistenceAssembler::class,
        );

        $this->app->singleton(
            PaymentFactory::class,
        );

        $this->app->singleton(
            PaymentRepository::class,
            EloquentPaymentRepository::class,
        );
    }
}
