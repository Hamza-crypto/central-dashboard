<?php

namespace App\Console\Commands;

use App\Models\File;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeleteUnusedEntries extends Command
{
    protected $signature = 'delete:unused-entries';

    protected $description = 'It deletes entries from DB which are irrelevant';

    public function handle()
    {
        $twoHoursAgo = Carbon::now()->subHours(8);

        File::whereNull('website_data')
            ->where('created_at', '<=', $twoHoursAgo)
            ->delete();
    }
}
