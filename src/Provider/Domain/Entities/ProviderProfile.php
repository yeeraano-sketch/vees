<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\Entities;

use Vees\Core\Provider\Domain\ValueObjects\City;
use Vees\Core\Provider\Domain\ValueObjects\FullName;
use Vees\Core\Provider\Domain\ValueObjects\PhoneNumber;
use Vees\Core\SharedKernel\Domain\Entity;

final class ProviderProfile extends Entity
{
    public function __construct(
        private FullName $fullName,
        private PhoneNumber $phoneNumber,
        private City $city,
    ) {}

    protected function identity(): mixed
    {
        return 'profile';
    }

    public function fullName(): FullName
    {
        return $this->fullName;
    }

    public function phoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    public function city(): City
    {
        return $this->city;
    }

    public function changeCity(City $city): void
    {
        $this->city = $city;
    }
}
