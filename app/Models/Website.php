<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
