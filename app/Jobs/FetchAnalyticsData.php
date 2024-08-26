<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Website;
use Spatie\Analytics\AnalyticsClient;
use App\Services\CustomAnalytics;

class FetchAnalyticsData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $websiteId;
    protected $period;
    protected $tbl_key;


    public function __construct($websiteId, $period, $tbl_key)
    {
        $this->websiteId = $websiteId;
        $this->period = $period;
        $this->tbl_key = $tbl_key;
    }

    public function handle(AnalyticsClient $client)
    {
        $website = Website::find($this->websiteId);

        if (!$website) {
            return;
        }

        $analytics = new CustomAnalytics($client, $website->view_id);
        $stats = $this->fetchStats($analytics, $this->period);

        // Update the website record with the new stats for the current period
        $column = "stats_{$this->tbl_key}";
        $website->update([$column => $stats]);
    }

    protected function fetchStats(CustomAnalytics $analytics, $period)
    {
        $maxResults = 30;

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

        return $stats;
    }
}
