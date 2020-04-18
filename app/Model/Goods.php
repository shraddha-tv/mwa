<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_id',
        'price',
        'unit_price',
        "category_id",
        "user_id",
        'available_amount',
        'state',
    ];

    public function goodsName(){
        return $this->belongsTo('App\Model\GoodsName','name_id');
    }

    public function farmer(){
        return $this->belongsTo('App\User','user_id');
    }
    
}
