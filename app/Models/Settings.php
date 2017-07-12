<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'chs_settings';

    protected $guarded = ['id'];

    public $timestamps = false;
}
