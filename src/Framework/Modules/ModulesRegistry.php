<?php

declare(strict_types=1);

namespace App\Framework\Modules;

use Illuminate\Contracts\Foundation\Application;

use App\SharedKernel\Application\Contracts\UnitOfWork;
use App\Framework\Persistence\LaravelUnitOfWork;

use App\SharedKernel\Application\EventBus\EventBus;
use App\SharedKernel\Application\EventBus\SynchronousEventBus;
use App\SharedKernel\Application\Dispatcher\EventDispatcher;
use App\SharedKernel\Application\Bus\TransactionalCommandBus;
use App\SharedKernel\Application\Transactions\AggregateCollector;
use App\SharedKernel\Application\Subscribers\SubscriberRegistry;

use App\Provider\Domain\Contracts\ProviderRepository;
use App\Provider\Domain\Aggregates\Provider\ProviderFactory;
use App\Provider\Infrastructure\Persistence\Eloquent\Mappers\ProviderMapper;
use App\Provider\Infrastructure\Persistence\Eloquent\Assemblers\ProviderPersistenceAssembler;
use App\Provider\Infrastructure\Persistence\Eloquent\Repositories\EloquentProviderRepository;

use App\Subscription\Domain\Contracts\SubscriptionRepository;
use App\Subscription\Domain\Aggregates\Subscription\SubscriptionFactory;
use App\Subscription\Infrastructure\Persistence\Eloquent\Mappers\SubscriptionMapper;
use App\Subscription\Infrastructure\Persistence\Eloquent\Assemblers\SubscriptionPersistenceAssembler;
use App\Subscription\Infrastructure\Persistence\Eloquent\Repositories\EloquentSubscriptionRepository;

use App\Payment\Domain\Contracts\PaymentRepository;
use App\Payment\Domain\Aggregates\Payment\PaymentFactory;
use App\Payment\Infrastructure\Persistence\Eloquent\Mappers\PaymentMapper;
use App\Payment\Infrastructure\Persistence\Eloquent\Assemblers\PaymentPersistenceAssembler;
use App\Payment\Infrastructure\Persistence\Eloquent\Repositories\EloquentPaymentRepository;

use App\Matching\Domain\Contracts\MatchingRepository;
use App\Matching\Domain\Aggregates\Matching\MatchingFactory;
use App\Matching\Infrastructure\Persistence\Eloquent\Mappers\MatchingMapper;
use App\Matching\Infrastructure\Persistence\Eloquent\Assemblers\MatchingPersistenceAssembler;
use App\Matching\Infrastructure\Persistence\Eloquent\Repositories\EloquentMatchingRepository;

use App\Session\Domain\Contracts\SessionRepository;
use App\Session\Domain\Aggregates\Session\SessionFactory;
use App\Session\Infrastructure\Persistence\Eloquent\Mappers\SessionMapper;
use App\Session\Infrastructure\Persistence\Eloquent\Assemblers\SessionPersistenceAssembler;
use App\Session\Infrastructure\Persistence\Eloquent\Repositories\EloquentSessionRepository;

use App\Notification\Domain\Contracts\NotificationRepository;
use App\Notification\Domain\Aggregates\Notification\NotificationFactory;
use App\Notification\Infrastructure\Persistence\Eloquent\Mappers\NotificationMapper;
use App\Notification\Infrastructure\Persistence\Eloquent\Assemblers\NotificationPersistenceAssembler;
use App\Notification\Infrastructure\Persistence\Eloquent\Repositories\EloquentNotificationRepository;

final readonly class ModulesRegistry
{
    public function __construct(
        private Application $app,
    ) {
    }

    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Infrastructure
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            UnitOfWork::class,
            LaravelUnitOfWork::class,
        );

        $this->app->singleton(AggregateCollector::class);

        $this->app->singleton(SubscriberRegistry::class);

        $this->app->singleton(
            EventBus::class,
            SynchronousEventBus::class,
        );

        $this->app->singleton(EventDispatcher::class);

        $this->app->singleton(TransactionalCommandBus::class);

        /*
        |--------------------------------------------------------------------------
        | Provider
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(ProviderMapper::class);
        $this->app->singleton(ProviderPersistenceAssembler::class);
        $this->app->singleton(ProviderFactory::class);
        $this->app->singleton(
            ProviderRepository::class,
            EloquentProviderRepository::class,
        );

        /*
        |--------------------------------------------------------------------------
        | Subscription
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(SubscriptionMapper::class);
        $this->app->singleton(SubscriptionPersistenceAssembler::class);
        $this->app->singleton(SubscriptionFactory::class);
        $this->app->singleton(
            SubscriptionRepository::class,
            EloquentSubscriptionRepository::class,
        );

        /*
        |--------------------------------------------------------------------------
        | Payment
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(PaymentMapper::class);
        $this->app->singleton(PaymentPersistenceAssembler::class);
        $this->app->singleton(PaymentFactory::class);
        $this->app->singleton(
            PaymentRepository::class,
            EloquentPaymentRepository::class,
        );

        /*
        |--------------------------------------------------------------------------
        | Matching
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(MatchingMapper::class);
        $this->app->singleton(MatchingPersistenceAssembler::class);
        $this->app->singleton(MatchingFactory::class);
        $this->app->singleton(
            MatchingRepository::class,
            EloquentMatchingRepository::class,
        );

        /*
        |--------------------------------------------------------------------------
        | Session
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(SessionMapper::class);
        $this->app->singleton(SessionPersistenceAssembler::class);
        $this->app->singleton(SessionFactory::class);
        $this->app->singleton(
            SessionRepository::class,
            EloquentSessionRepository::class,
        );

        /*
        |--------------------------------------------------------------------------
        | Notification
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(NotificationMapper::class);
        $this->app->singleton(NotificationPersistenceAssembler::class);
        $this->app->singleton(NotificationFactory::class);
        $this->app->singleton(
            NotificationRepository::class,
            EloquentNotificationRepository::class,
        );
    }
}
