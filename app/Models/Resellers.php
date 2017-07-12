<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Resellers extends Authenticatable
{
    use Notifiable;

    protected $table = 'chs_resellers';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'password',
        'status',
        'email',
        'discount_rate',
        'balance',
        'reg_datetime',
        'last_login_datetime', 
        'last_login_ip', 
        'last_login_geocountry'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = false;
}