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
        'stats' => 'array'
    ];

    public function files()
    {
        return $this->belongsToMany(File::class, 'file_website')->withTimestamps();
    }
}
