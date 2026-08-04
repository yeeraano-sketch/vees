<?php

declare(strict_types=1);

namespace Vees\Core\Matching\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class DispatchSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sessionId' => ['required', 'uuid'],
            'serviceType' => ['required', 'integer', 'min:1'],
            'cityId' => ['required', 'string', 'max:100'],
        ];
    }
}
