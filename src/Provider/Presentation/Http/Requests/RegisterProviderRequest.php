<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class RegisterProviderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullName'    => ['required', 'string', 'max:255'],
            'phoneNumber' => ['required', 'string', 'max:20'],
            'city'        => ['required', 'string', 'max:100'],
            'workMode'    => ['required', 'string', 'in:taxi,delivery,taxi_delivery'],
        ];
    }
}
