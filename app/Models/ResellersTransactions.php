<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResellersTransactions extends Model
{
    protected $table = 'chs_resellers_transactions';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function voucher()
    {
    	return $this->belongsTo(Vouchers::class, 'voucher_id');
    }
}
