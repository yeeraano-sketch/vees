<?php

declare(strict_types=1);

namespace App\Provider\Domain\Entities;

use App\Provider\Domain\ValueObjects\City;
use App\Provider\Domain\ValueObjects\FullName;
use App\Provider\Domain\ValueObjects\PhoneNumber;
use App\SharedKernel\Domain\Entity;

final class ProviderProfile extends Entity
{
    public function __construct(
        private FullName $fullName,
        private PhoneNumber $phoneNumber,
        private City $city,
    ) {
    }

    protected function identity(): mixed
    {
        return $this->phoneNumber->value();
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
