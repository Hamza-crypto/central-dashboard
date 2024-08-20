<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendPostRequestToWebsite implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $websiteUrl;
    protected $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $websiteUrl, array $payload)
    {
        $this->websiteUrl = $websiteUrl;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send the POST request
        Http::post($this->websiteUrl, [
            'data' => $this->payload
        ]);
    }
}
