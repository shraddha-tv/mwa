<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsName extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'name_sin',
        'name_eng',
        'state',
    ];
}