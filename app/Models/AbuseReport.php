<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbuseReport extends Model
{
    protected $table = 'chs_abuse_reports';

    protected $guarded = ['id'];

    public $timestamps = false;

    public static $rules = [
		'report'		=> [
			'name'					=> 'required',
			'organization'			=> 'required',
			'email'					=> 'required|email',
			'links'					=> 'required',
			'reason'				=> 'required',
			'g-recaptcha-response'  => 'required',
			'accept'				=> 'accepted',
		],
	];
}
