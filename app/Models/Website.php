<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class Website extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'preferred_columns' => 'array',
        'stats_1h' => 'array',
        'stats_1d' => 'array',
        'stats_1w' => 'array',
        'stats_1mo' => 'array',
        'stats_3mo' => 'array',
        'stats_6mo' => 'array',
        'stats_12mo' => 'array'
];

    public function files()
    {
        return $this->belongsToMany(File::class, 'file_website')->withTimestamps();
    }

    protected static function booted()
    {
        static::created(function ($website) {
            // Check if the view_id is filled
            if (!empty($website->view_id)) {


                Artisan::call('analytics:fetch', [
                                    'website_id' => $website->id
                                ]);

                Artisan::call('analytics:fetch-hourly', [
                    'website_id' => $website->id
                ]);

            }
        });

        static::updated(function ($website) {
            // Check if the view_id is filled
            if (!empty($website->view_id) && $website->isDirty('view_id')) {

                Artisan::call('analytics:fetch', [
                                    'website_id' => $website->id
                                ]);

                Artisan::call('analytics:fetch-hourly', [
                    'website_id' => $website->id
                ]);

            }

        });
    }
}
