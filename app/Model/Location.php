<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'address',
        'district',
        'province',
        'gs_division',
        'divisional_secretariat',
        'latitude',
        'longitude',
        'user_id',
        'state',
    ];
}
