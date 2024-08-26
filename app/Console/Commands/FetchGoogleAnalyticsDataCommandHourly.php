<?php

namespace App\Console\Commands;

use App\Jobs\FetchAnalyticsData;
use App\Models\Website;
use Illuminate\Console\Command;
use Spatie\Analytics\AnalyticsClient;
use Spatie\Analytics\Period;
use Illuminate\Support\Carbon;

class FetchGoogleAnalyticsDataCommandHourly extends Command
{
    protected $signature = 'analytics:fetch-hourly';
    protected $description = 'Fetch Google Analytics data for all websites and store in the database';

    protected $analyticsClient;

    public function __construct(AnalyticsClient $client)
    {
        parent::__construct();
        $this->analyticsClient = $client;
    }

    public function handle()
    {
        $this->info('Fetching Google Analytics data...');

        $endDate = Carbon::now();
        $startDate = Carbon::now()->subHours(1);

        $one_hour = Period::create($startDate, $endDate);


        $periods = [
            '1h' => $one_hour
        ];

        $websites = Website::whereNotNull('view_id')->get();

        foreach ($websites as $website) {
            foreach ($periods as $tbl_key => $period) {
                FetchAnalyticsData::dispatch($website->id, $period, $tbl_key);
            }
        }

        $this->info('Jobs dispatched successfully.');

    }

}
