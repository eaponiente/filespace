<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = 'chs_countries';

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $dates = ['datetime_banned'];

    public function scopeBanned($query)
    {
    	return $query->where('is_banned', 1);
    }
}
