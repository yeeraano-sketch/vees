<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Application\DTOs;

use Vees\Core\Provider\Domain\Aggregates\Provider\Provider;

final readonly class ProviderDto
{
    public function __construct(
        public string $id,
        public string $fullName,
        public string $phoneNumber,
        public string $city,
        public string $workMode,
        public string $status,
        public bool $verified,
        public string $availability,
    ) {}

    public static function fromAggregate(
        Provider $provider,
    ): self {

        return new self(
            id: (string) $provider->id(),
            fullName: $provider->profile()->fullName()->value(),
            phoneNumber: $provider->profile()->phoneNumber()->value(),
            city: $provider->profile()->city()->value(),
            workMode: $provider->workMode()->value,
            status: $provider->verification()->status()->value,
            verified: $provider->verification()->verified(),
            availability: $provider->availability()->status()->value,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->fullName,
            'phoneNumber' => $this->phoneNumber,
            'city' => $this->city,
            'workMode' => $this->workMode,
            'status' => $this->status,
            'verified' => $this->verified,
            'availability' => $this->availability,
        ];
    }
}
