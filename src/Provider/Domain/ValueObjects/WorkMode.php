<?php

declare(strict_types=1);

namespace Vees\Core\Provider\Domain\ValueObjects;

enum WorkMode: string
{
    case Taxi = 'taxi';
    case Delivery = 'delivery';
    case TaxiAndDelivery = 'taxi_and_delivery';

    public function supportsTaxi(): bool
    {
        return $this === self::Taxi
            || $this === self::TaxiAndDelivery;
    }

    public function supportsDelivery(): bool
    {
        return $this === self::Delivery
            || $this === self::TaxiAndDelivery;
    }
}
