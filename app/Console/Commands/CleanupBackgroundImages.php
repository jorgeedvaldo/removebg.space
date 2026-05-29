<?php

namespace App\Console\Commands;

use App\Services\BackgroundRemover;
use Illuminate\Console\Command;

class CleanupBackgroundImages extends Command
{
    protected $signature = 'bg:cleanup';

    protected $description = 'Delete background-removal uploads/results older than the retention window';

    public function handle(BackgroundRemover $remover): int
    {
        $removed = $remover->cleanup();

        $this->info("Removed {$removed} expired background-removal job(s).");

        return self::SUCCESS;
    }
}
