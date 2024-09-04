<?php


use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\WebsiteController;
use App\Models\Website;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\AnalyticsClient;
use Spatie\Analytics\Period;
use App\Services\CustomAnalytics;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/dashboard');

Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');

//->middleware(['auth', 'verified'])

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Route::get('migrate_fresh', function () {
//     Artisan::call('migrate:fresh');
//     dump('Database Reset Successfully');
// });


Route::get('migrate', function () {
    Artisan::call('migrate');
    dump('Migration Done');
});



Route::get('optimize', function () {
    Artisan::call('optimize:clear');
    dump('Optimization Done');



});


Route::get('storage-link', function () {
    $target = storage_path('app/public');
    $linkfolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($target, $linkfolder);

    dump($target, $linkfolder);

    dump('Link Created');
});


require __DIR__.'/auth.php';

Route::delete('/files/delete-all', [FileController::class, 'deleteAll'])->name('files.deleteAll');
Route::resource('websites', WebsiteController::class);
Route::resource('files', FileController::class);

Route::post('sync_data', [FileController::class,'sync_data'])->name('data.sync');



Route::get('sync', function () {
    Artisan::call('sync:wordpress-laravel');

});


Route::get('fetch-analytics', function () {
    Artisan::call('analytics:fetch');
    Artisan::call('analytics:fetch-hourly');
});


// In your route:
Route::get('test-analytics', function (AnalyticsClient $client) {
    $analytics = new CustomAnalytics($client, '317504004');
    $period = Period::months(7);
    $max_results = 3;

    # unique visitors
    # pages
    # duration
    # bounce rate
    # number of clicks on a listing
    # number of revenue per site

    $unique_visitors = $analytics->fetchUniqueVisitorsByPage(
        period: $period,
        maxResults: $max_results
    );

    dd($unique_visitors);


    $revenue_per_site = $analytics->fetchRevenuePerSite(
        period: $period,
        maxResults: $max_results
    );



    $click_on_listings = $analytics->fetchClicksOnListing(
        period: $period,
        maxResults: $max_results
    );




    $bounce_rate = $analytics->fetchPageViewsAndBounceRate(
        period: $period,
        maxResults: $max_results
    );
    $avg_session = $analytics->fetchAverageSessionDuration(
        period: $period
    );



    // dump($unique_visitors, $bounce_rate, $avg_session, $click_on_listings, $revenue_per_site);



    $website = Website::find(1);
    if ($website) {
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

            'avg_session' => $avg_session->first()['averageSessionDuration'] ?? null,

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

        dd('Data saved successfully!', $stats);
    } else {
        dd('Website not found.');
    }

});


Route::get('store-analytics', function () {


});


/**
 * To Get Started
 * Wordpress:
 *
* http://localhost/unused-images/wp-admin/edit.php?post_status=trash&post_type=wecptbs
* DELETE FROM `wp_postmeta` where post_id > 22540;
* DELETE FROM `wp_posts` where id > 22540
 */
