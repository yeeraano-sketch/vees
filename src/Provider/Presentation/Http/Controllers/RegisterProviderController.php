<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Presentation\Http\Controllers;

use Illuminate\Routing\Controller;

use Vees\Core\Provider\Application\Commands\RegisterProviderCommand;
use Vees\Core\Provider\Application\Services\RegisterProviderService;

use Vees\Core\Provider\Presentation\Http\Requests\RegisterProviderRequest;
use Vees\Core\Provider\Presentation\Http\Responses\RegisterProviderResponse;

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
