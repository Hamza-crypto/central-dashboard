<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileEntry extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'website_data' => 'array',
    ];

    public function getWebsiteDataAttribute($value)
    {
        return json_decode($value, true);
    }
}