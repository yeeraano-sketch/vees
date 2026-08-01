<?php

declare(strict_types=1);

namespace App\Provider\Presentation\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Provider\Application\Commands\RegisterProviderCommand;
use App\Provider\Application\Services\RegisterProviderService;

use App\Provider\Presentation\Http\Requests\RegisterProviderRequest;
use App\Provider\Presentation\Http\Responses\RegisterProviderResponse;

final class RegisterProviderController extends Controller
{
    public function __construct(
        private readonly RegisterProviderService $service,
    ) {
    }

    public function __invoke(
        RegisterProviderRequest $request,
    ) {

        $command = RegisterProviderCommand::fromRequest($request);

        $result = $this->service->register($command);

        return RegisterProviderResponse::created(
            (string) $result->id(),
        );
    }
}
