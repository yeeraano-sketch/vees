<?php

declare(strict_types=1);

namespace Vees\Core\Recovery\Infrastructure\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vees\Core\Recovery\Application\Services\RecoveryEngine;

final class RecoverStaleSessionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(RecoveryEngine $engine): void
    {
        $engine->recoverStaleSessions();
    }
}
