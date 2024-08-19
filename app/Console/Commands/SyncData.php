<?php

namespace App\Console\Commands;

use App\Models\FileEntry;
use Illuminate\Console\Command;

class SyncData extends Command
{
    protected $signature = 'sync:wordpress-laravel';

    protected $description = 'It sends data to wordpress website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = FileEntry::where('active', 1)->first();

    }
}