<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteCodeStats extends Model
{
    protected $table = 'chs_website_code_stats';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function websitecode()
    {
    	return $this->belongsTo(WebsiteCodes::class, 'website_code_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'website_owner_user_id');
    }
}
