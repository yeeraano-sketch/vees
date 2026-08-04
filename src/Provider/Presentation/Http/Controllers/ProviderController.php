<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Presentation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Vees\Core\Provider\Application\Commands\RegisterProviderCommand;
use Vees\Core\SharedKernel\Application\Bus\CommandBus;

final class ProviderController extends Controller
{
    public function __construct(
        private CommandBus $bus,
    ) {
    }

    public function store(RegisterProviderRequest $request): JsonResponse
    {
        $command = new RegisterProviderCommand(
            id: $request->input('id'),
            fullName: $request->input('fullName'),
            phoneNumber: $request->input('phoneNumber'),
            city: $request->input('city'),
            workMode: $request->input('workMode'),
        );

        $provider = $this->bus->dispatch($command);

        return response()->json($provider->snapshot(), 201);
    }
}
