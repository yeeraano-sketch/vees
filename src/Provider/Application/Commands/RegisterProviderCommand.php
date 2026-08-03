<?php

declare(strict_types=1);

namespace App\Provider\Application\Commands;

use App\SharedKernel\Application\Contracts\Command;
use App\Provider\Presentation\Http\Requests\RegisterProviderRequest;
use Ramsey\Uuid\Uuid;

final readonly class RegisterProviderCommand implements Command
{
    public function __construct(
        public string $id,
        public string $fullName,
        public string $phoneNumber,
        public string $city,
        public string $workMode,
    ) {
    }

    public static function fromRequest(RegisterProviderRequest $request): self
    {
        return new self(
            id: Uuid::uuid4()->toString(),
            fullName: $request->input('fullName'),
            phoneNumber: $request->input('phoneNumber'),
            city: $request->input('city'),
            workMode: $request->input('workMode'),
        );
    }
}
