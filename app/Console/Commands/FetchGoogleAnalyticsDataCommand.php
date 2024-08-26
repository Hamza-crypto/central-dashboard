<?php

namespace App\Console\Commands;

use App\Services\AnalyticsDataFetcherService;
use Illuminate\Console\Command;
use Spatie\Analytics\Period;

class FetchGoogleAnalyticsDataCommand extends Command
{
    protected $signature = 'analytics:fetch {website_id?}';
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

        $periods = [
            '1d' => Period::days(1),
            '1w' => Period::days(7),
            '1mo' => Period::months(1),
            '3mo' => Period::months(3),
            '6mo' => Period::months(6),
            '12mo' => Period::years(1),
        ];

        $this->dataFetcher->fetchAndDispatchJobs($periods, $website_id);

        $this->info('Jobs dispatched successfully.');
    }

}
