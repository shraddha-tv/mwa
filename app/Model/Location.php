<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = [
        ' address',
        ' district',
        ' province',
        ' grama_niladari_wasama',
        ' divisional_secretariat',
        ' state',
    ];
}
