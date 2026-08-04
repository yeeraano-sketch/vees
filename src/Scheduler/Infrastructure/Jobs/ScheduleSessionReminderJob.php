<?php

declare(strict_types=1);

namespace Vees\Core\Scheduler\Infrastructure\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class ScheduleSessionReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $sessionId,
    ) {
    }

    public function handle(): void
    {
        // إرسال تذكير للعميل والمزود
    }
}
