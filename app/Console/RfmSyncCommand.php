<?php

declare(strict_types=1);

use Illuminate\App\Console\Command;


class RfmSyncCommand extends Command
{
    protected $signature = 'rfm:sync';
    // php artisan amjad;:sync
    public function handle()
    {
        DataSyncJob::dispatch();
    }
}
