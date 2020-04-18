<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'state',
    ];
}
