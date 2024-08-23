<?php

namespace App\Console\Commands;

use App\Models\Website;
use Illuminate\Console\Command;
use Spatie\Analytics\AnalyticsClient;
use Spatie\Analytics\Period;
use App\Services\CustomAnalytics;

class FetchGoogleAnalyticsData extends Command
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

        // Define the period and max results
        $period = Period::months(7);
        $maxResults = 30;

        // Get all websites
        $websites = Website::whereNotNull('view_id')->get();

        foreach ($websites as $website) {
            $this->info("Processing website: {$website->url}");

            // Initialize your custom analytics service
            $analytics = new CustomAnalytics($this->analyticsClient, $website->view_id);

            // Fetch data
            $unique_visitors = $analytics->fetchUniqueVisitorsByPage(
                period: $period,
                maxResults: $maxResults
            );

            $click_on_listings = $analytics->fetchClicksOnListing(
                period: $period,
                maxResults: $maxResults
            );

            $revenue_per_site = $analytics->fetchRevenuePerSite(
                period: $period,
                maxResults: $maxResults
            );

            // Prepare the stats data
            $stats = [
                'unique_visitors' => $unique_visitors->map(function ($item) {
                    return [
                        'pagePath' => $item['pagePath'],
                        'pageTitle' => $item['pageTitle'],
                        'activeUsers' => $item['activeUsers'],
                        'screenPageViews' => $item['screenPageViews'],
                        'bounceRate' => $item['bounceRate'],
                        'averageSessionDuration' => $item['averageSessionDuration'],
                    ];
                })->toArray(),

                'click_on_listings' => $click_on_listings->map(function ($item) {
                    return [
                        'pagePath' => $item['pagePath'],
                        'eventCount' => $item['eventCount'],
                        'eventCountPerUser' => $item['eventCountPerUser'],
                    ];
                })->toArray(),

                'revenue_per_site' => $revenue_per_site->map(function ($item) {
                    return [
                        'pagePath' => $item['pagePath'],
                        'eventCount' => $item['eventCount'],
                        'eventCountPerUser' => $item['eventCountPerUser'],
                    ];
                })->toArray(),
            ];

            // Update the website record with the new stats
            $website->update(['stats' => $stats]);

            $this->info("Data for website {$website->url} updated successfully.");
        }

        $this->info('All websites processed successfully.');
    }

}
