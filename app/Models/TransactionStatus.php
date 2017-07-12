<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    protected $table = 'chs_transactions_status';

    protected $guarded = ['id'];

    public $timestamps = false;
}
