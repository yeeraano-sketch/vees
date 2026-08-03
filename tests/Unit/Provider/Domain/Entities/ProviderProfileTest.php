<?php

declare(strict_types=1);

namespace Tests\Unit\Provider\Domain\Entities;

use App\Provider\Domain\Entities\ProviderProfile;
use App\Provider\Domain\ValueObjects\FullName;
use App\Provider\Domain\ValueObjects\PhoneNumber;
use App\Provider\Domain\ValueObjects\City;
use PHPUnit\Framework\TestCase;

class ProviderProfileTest extends TestCase
{
    public function test_create_profile(): void
    {
        $fullName = new FullName('John');
        $phone = new PhoneNumber('+966501234567');
        $city = new City('Riyadh');
        
        $profile = new ProviderProfile($fullName, $phone, $city);
        
        $this->assertSame($fullName, $profile->fullName());
        $this->assertSame($phone, $profile->phoneNumber());
        $this->assertSame($city, $profile->city());
    }

    public function test_change_city(): void
    {
        $profile = new ProviderProfile(
            new FullName('John'),
            new PhoneNumber('+966501234567'),
            new City('Riyadh')
        );
        
        $newCity = new City('Jeddah');
        $profile->changeCity($newCity);
        
        $this->assertSame($newCity, $profile->city());
    }
}
