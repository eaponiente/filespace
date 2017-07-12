<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteCodes extends Model
{
    protected $table = 'chs_websites_code';

    protected $guarded = ['id'];

    public $timestamps = false;
}
