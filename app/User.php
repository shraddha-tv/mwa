<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','name_eng','password','nic','state_id','type','create_by','verified_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function locations(){
        return $this->hasMany('App\Model\Location');
    }

    public function contacts(){
        return $this->hasMany('App\Model\Contact');
    }

    public function createBy(){
        return $this->belongsTo('App\User','create_by');
    }

    public function verifyBy(){
        return $this->belongsTo('App\User','verified_by');
    }

    public function goods(){
        return $this->hasMany('App\Model\Goods');
    }
}
