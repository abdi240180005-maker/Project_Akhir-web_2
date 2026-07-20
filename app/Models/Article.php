<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'country',
        'risk_level',
        'conclusion',
        'category',
        'author',
    ];
}