<?php

namespace App\Console\Commands;

use App\Imports\GetData;
use App\Models\FileEntry;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class SyncData extends Command
{
    protected $signature = 'sync:wordpress-laravel';

    protected $description = 'It sends data to wordpress website';

    public function handle()
    {
        $file = FileEntry::where('active', 1)->first();
        $websites = $file->website_data;
        $filePath = storage_path('app/' . $file->filepath);

        foreach($websites as $website_id => $categories) {
            $ws = Website::find($website_id);

            $import = new GetData($categories);
            Excel::import($import, $filePath);
            $dataToSend = $import->getFilteredRows();

            $apiUrl = $ws->url . '/wp-json/custom-import/v1/import';
            Http::post($apiUrl, [
                'data' => $dataToSend
            ]);

        }



    }
}
