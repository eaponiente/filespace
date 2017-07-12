<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpBan extends Model
{
    protected $table = 'chs_ip_ban';

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $dates = ['datetime_added'];
}
