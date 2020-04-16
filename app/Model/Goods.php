<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'unit_price',
        'available_amount',
        'state',
    ];
    
}
