<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fileserver extends Model
{
    protected $table = 'chs_fileserver';

    protected $guarded = ['id'];

    public $timestamps = false;

    public static function check_local_fileserver_on()
	{
		$fs = Filenas::where('statusId', 2)->where('serverType', 'local')->count();
		
		return $fs > 0;
	}

	public static function check_fileservers()
	{
		$fs = Filenas::where( 'statusId', '=', 2 )
		->orWhere( 'statusId', '=', 3)
		->count();

		
		return $fs > 0;
	}
}
