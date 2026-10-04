<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_rating',
        'service_rating',
        'hygiene_rating',
        'overall_experience',
        'phone',
        'comment'
    ];

    protected $casts = [
        'staff_rating' => 'integer',
        'service_rating' => 'integer',
        'hygiene_rating' => 'integer',
    ];
}
