<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    protected $fillable = [
        'port_name',
        'country',
        'city',
        'latitude',
        'longitude',
    ];
}