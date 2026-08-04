<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Presentation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Vees\Core\Matching\Application\Commands\DispatchSessionCommand;
use Vees\Core\SharedKernel\Application\Bus\CommandBus;
use Ramsey\Uuid\Uuid;

final class MatchingController extends Controller
{
    public function __construct(
        private CommandBus $bus,
    ) {
    }

    public function dispatch(DispatchSessionRequest $request): JsonResponse
    {
        $command = new DispatchSessionCommand(
            sessionId: $request->input('sessionId'),
            serviceType: (int) $request->input('serviceType'),
            cityId: $request->input('cityId'),
        );

        $providerId = $this->bus->dispatch($command);

        return response()->json(['providerId' => $providerId], 201);
    }
}
