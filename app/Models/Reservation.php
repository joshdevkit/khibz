<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_number',
        'status',
        'name',
        'email',
        'contact',
        'guests',
        'payment_reference',
        'screenshot',
        'date', 
    ];
}

