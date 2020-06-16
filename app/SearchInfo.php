<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchInfo extends Model
{
    protected $fillable = [
        'visitor',
        'searched_coordinates',
        'searched_cities',
        'distance',
    ];
}
