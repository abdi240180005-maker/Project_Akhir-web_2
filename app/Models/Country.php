<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'iso2',
        'iso3',
        'capital',
        'region',
        'subregion',
        'currency',
        'population',
        'latitude',
        'longitude',
        'flag',
        'un_member',
        'independent',
        'gdp',
        'inflation_rate',
        'risk_score',
    ];
}