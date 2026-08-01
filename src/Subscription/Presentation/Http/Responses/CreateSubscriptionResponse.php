<?php

declare(strict_types=1);

namespace App\Subscription\Presentation\Http\Responses;

use Illuminate\Http\JsonResponse;

final class CreateSubscriptionResponse
{
    public static function created(
        string $id,
    ): JsonResponse {

        return response()->json([

            'success' => true,

            'subscriptionId' => $id,

        ],201);
    }
}
