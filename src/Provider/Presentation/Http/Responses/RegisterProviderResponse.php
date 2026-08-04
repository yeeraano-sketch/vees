<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Presentation\Http\Responses;

use Illuminate\Http\JsonResponse;

final class RegisterProviderResponse
{
    public static function created(
        string $id,
    ): JsonResponse {

        return response()->json([
            'success' => true,
            'providerId' => $id,
        ], 201);
    }
}
