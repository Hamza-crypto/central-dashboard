<?php

namespace App\Console\Commands;

use App\Services\AnalyticsDataFetcherService;
use Illuminate\Console\Command;
use Spatie\Analytics\Period;
use Illuminate\Support\Carbon;

class FetchGoogleAnalyticsDataCommandHourly extends Command
{
    protected $signature = 'analytics:fetch-hourly {website_id?}';
    protected $description = 'Fetch Google Analytics data for all websites and store in the database';
    protected $dataFetcher;

    public function __construct(AnalyticsDataFetcherService $dataFetcher)
    {
        parent::__construct();
        $this->dataFetcher = $dataFetcher;
    }

    public function handle()
    {
        $website_id = $this->argument('website_id');
        $this->info('Fetching Google Analytics data...');

        $endDate = Carbon::now();
        $startDate = Carbon::now()->subHours(1);

        $periods = [
            '1h' => Period::create($startDate, $endDate),
        ];

        $this->dataFetcher->fetchAndDispatchJobs($periods, $website_id);

        $this->info('Jobs dispatched successfully.');
    }

}
