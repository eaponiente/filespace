<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'chs_transactions';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
