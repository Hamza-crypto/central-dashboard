<?php

namespace App\Services;

use App\Jobs\FetchAnalyticsData;
use App\Models\Website;

class AnalyticsDataFetcherService
{
    public function fetchAndDispatchJobs(array $periods, $website_id = null)
    {
        $websites = $website_id
                    ? Website::where('id', $website_id)->whereNotNull('view_id')->get()
                    : Website::whereNotNull('view_id')->get();

        foreach ($websites as $website) {
            foreach ($periods as $tbl_key => $period) {
                FetchAnalyticsData::dispatch($website->id, $period, $tbl_key);
            }
        }
    }
}
