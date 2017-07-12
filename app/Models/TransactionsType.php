<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionsType extends Model
{
    protected $table = 'chs_transactions_type';

    protected $guarded = ['id'];

    public $timestamps = false;
}
