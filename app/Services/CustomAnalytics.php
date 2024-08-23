<?php

namespace App\Services;

use Spatie\Analytics\Analytics as BaseAnalytics;
use Google\Analytics\Data\V1beta\FilterExpression;
use Illuminate\Support\Collection;
use Spatie\Analytics\Period;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;
use Spatie\Analytics\OrderBy;

class CustomAnalytics extends BaseAnalytics
{
    public function fetchUniqueVisitorsByPage(Period $period, int $maxResults = 10, int $offset = 0): Collection
    {
        return $this->get(
            period: $period,
            metrics: ['activeUsers', 'screenPageViews','bounceRate','averageSessionDuration' ],
            dimensions: ['pagePath', 'pageTitle'],
            maxResults: $maxResults,
            orderBy: [
                OrderBy::metric('activeUsers', true),
            ],
            offset: $offset,
        );
    }

    public function fetchPageViewsAndBounceRate(Period $period, int $maxResults = 10, int $offset = 0): Collection
    {
        return $this->get(
            period: $period,
            metrics: ['screenPageViews', 'bounceRate'],
            dimensions: ['pageTitle'],
            maxResults: $maxResults,
            offset: $offset,
        );
    }

    public function fetchAverageSessionDuration(Period $period): Collection
    {
        return $this->get(
            period: $period,
            metrics: ['averageSessionDuration'],
        );
    }

    public function fetchClicksOnListing(Period $period, string $eventName = 'click', int $maxResults = 10, int $offset = 0): Collection
    {
        // Dimension Filter for event name "click"
        $dimensionFilter = new FilterExpression([
            'filter' => new Filter([
                'field_name' => 'eventName',
                'string_filter' => new StringFilter([
                    'match_type' => MatchType::EXACT,
                    'value' => 'click',
                ]),
            ]),
        ]);

        return $this->get(
            period: $period,
            metrics: ['eventCount', 'eventCountPerUser'], // or 'clicks' if that's the metric name
            dimensions: ['pagePath'],
            maxResults: $maxResults,
            offset: $offset,
            dimensionFilter: $dimensionFilter
        );
    }

    public function fetchRevenuePerSite(Period $period, int $maxResults = 10, int $offset = 0): Collection
    {
        return $this->get(
            period: $period,
            metrics: ['totalRevenue', 'totalPurchasers', 'transactions'],
            dimensions: ['pagePath'],
            maxResults: $maxResults,
            orderBy: [
                OrderBy::metric('totalRevenue', true),
            ],
            offset: $offset,
        );
    }

}
