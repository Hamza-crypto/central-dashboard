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
        $maxResults = 10;

        // Get all websites
        $websites = Website::all();

        foreach ($websites as $website) {
            $this->info("Processing website: {$website->url}");

            // Initialize your custom analytics service
            $analytics = new CustomAnalytics($this->analyticsClient, $website->view_id);

            // Fetch data
            $unique_visitors = $analytics->fetchUniqueVisitorsByPage(
                period: $period,
                maxResults: $maxResults
            );

            $bounce_rate = $analytics->fetchPageViewsAndBounceRate(
                period: $period,
                maxResults: $maxResults
            );

            $avg_session = $analytics->fetchAverageSessionDuration(
                period: $period
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
                        'activeUsers' => $item['activeUsers'],
                    ];
                })->toArray(),

                'bounce_rate' => $bounce_rate->map(function ($item) {
                    return [
                        'pageTitle' => $item['pageTitle'],
                        'screenPageViews' => $item['screenPageViews'],
                        'bounceRate' => $item['bounceRate'],
                    ];
                })->toArray(),

                'avg_session' => $avg_session->first()->averageSessionDuration ?? null,

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
