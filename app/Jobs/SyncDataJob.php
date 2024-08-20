<?php

namespace App\Jobs;

use App\Models\FileEntry;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GetData;

class SyncDataJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $file_id;


    public function __construct($file_id)
    {
        $this->file_id = $file_id;
    }


    public $tries = 10;


    public function handle()
    {
        $file = FileEntry::find($this->file_id);
        if (!$file) {
            return;
        }

        $websites = $file->website_data;
        $filePath = storage_path('app/' . $file->filepath);

        foreach ($websites as $website_id => $categories) {
            $ws = Website::find($website_id);

            if (!$ws) {
                continue;
            }
            $import = new GetData($categories);
            Excel::import($import, $filePath);
            $dataToSend = $import->getFilteredRows();

            $apiUrl = $ws->url;
            Http::timeout(100)->post($apiUrl, [
                'data' => $dataToSend
            ]);
        }

        $file->active = 0;
        $file->save();
    }
}
