<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'token',
        'preffered_columns',
        'view_id',
        'stats',
    ];

    protected $casts = [
        'preferred_columns' => 'array',
        'stats' => 'array',
    ];
}
