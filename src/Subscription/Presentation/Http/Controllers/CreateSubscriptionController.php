<?php

declare(strict_types=1);

namespace App\Subscription\Presentation\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Subscription\Application\Commands\CreateSubscriptionCommand;
use App\Subscription\Application\Services\CreateSubscriptionService;

use App\Subscription\Presentation\Http\Requests\CreateSubscriptionRequest;
use App\Subscription\Presentation\Http\Responses\CreateSubscriptionResponse;

final class CreateSubscriptionController extends Controller
{
    public function __construct(
        private readonly CreateSubscriptionService $service,
    ) {
    }

    public function __invoke(
        CreateSubscriptionRequest $request,
    ) {

        $subscription = $this->service->create(

            new CreateSubscriptionCommand(

                providerId: $request->string('providerId')->toString(),

                plan: $request->string('plan')->toString(),
            )
        );

        return CreateSubscriptionResponse::created(

            (string) $subscription->id(),

        );
    }
}
