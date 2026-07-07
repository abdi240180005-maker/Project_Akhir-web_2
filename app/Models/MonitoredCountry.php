<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoredCountry extends Model
{
    protected $fillable = [
        'country_name',
        'country_code',
        'capital',
        'region',
        'population',
        'currency',
        'flag',
    ];
}