<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'dj_name', 'event_date', 'description', 'image'];

    // Cast event_date to a DateTime object
    protected $casts = [
        'event_date' => 'date',
    ];
}
