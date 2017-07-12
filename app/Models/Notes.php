<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $table = 'chs_notes';

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $dates = ['note_date'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
