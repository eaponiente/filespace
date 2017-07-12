<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'chs_packages';

    protected $guarded = ['id'];

    public $timestamps = false;
}
