<?php

declare(strict_types=1);

namespace App\Subscription\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CreateSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'providerId' => ['required','uuid'],

            'plan' => [
                'required',
                'in:trial,monthly,quarterly,yearly',
            ],
        ];
    }
}
