<?php

declare(strict_types=1);

namespace App\Provider\Presentation\Http\Requests;

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
            //
        ];
    }
}
