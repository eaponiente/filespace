<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filenas extends Model
{
    protected $table = 'chs_filenas';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function status()
    {
    	return $this->belongsTo(FilenasStatus::class, 'statusId');
    }

    public static function get_file_servers()
	{	
		$fs = Filenas::where('statusId', 2)->get();

		$servers = $fs->toArray();	
		
		return $servers;
	}
}
