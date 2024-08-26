<?php

namespace App\Console\Commands;

use App\Jobs\FetchAnalyticsData;
use App\Models\Website;
use Illuminate\Console\Command;
use Spatie\Analytics\AnalyticsClient;
use Spatie\Analytics\Period;

class FetchGoogleAnalyticsDataCommand extends Command
{
    protected $signature = 'analytics:fetch';
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

        // Define the periods
        $periods = [
            '1d' => Period::days(1),
            '1w' => Period::days(7),
            '1mo' => Period::months(1),
            '3mo' => Period::months(3),
            '6mo' => Period::months(6),
            '12mo' => Period::years(1),
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
