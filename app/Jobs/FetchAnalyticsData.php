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
        // Fetch data and prepare stats as in your previous example
        // Implement fetchUniqueVisitorsByPage, fetchClicksOnListing, fetchRevenuePerSite
        return [
            'unique_visitors' => $analytics->fetchUniqueVisitorsByPage(
                period: $period,
                maxResults: $maxResults
            )->map(function ($item) {
                return [
                    'pagePath' => $item['pagePath'],
                    'pageTitle' => $item['pageTitle'],
                    'activeUsers' => $item['activeUsers'],
                    'screenPageViews' => $item['screenPageViews'],
                    'bounceRate' => $item['bounceRate'],
                    'averageSessionDuration' => $item['averageSessionDuration'],
                ];
            })->toArray(),
            // Add other data fetching methods here
        ];
    }
}