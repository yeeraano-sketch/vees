<?php

declare(strict_types=1);

namespace Tests\Unit\Provider\Domain\Entities;

use App\Provider\Domain\Entities\ProviderSettings;
use App\Provider\Domain\ValueObjects\WorkMode;
use PHPUnit\Framework\TestCase;

class ProviderSettingsTest extends TestCase
{
    public function test_create(): void
    {
        $s = new ProviderSettings(WorkMode::Taxi);
        $this->assertSame(WorkMode::Taxi, $s->workMode());
    }

    public function test_change_work_mode(): void
    {
        $s = new ProviderSettings(WorkMode::Taxi);
        $s->changeWorkMode(WorkMode::Delivery);
        $this->assertSame(WorkMode::Delivery, $s->workMode());
    }
}
