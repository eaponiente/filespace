<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    protected $table = 'chs_vouchers';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function reseller()
    {
    	return $this->belongsTo(Resellers::class, 'reseller_id');
    }
}
