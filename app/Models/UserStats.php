<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStats extends Model
{
    protected $table = 'chs_user_stats';

    protected $guarded = ['id'];

    public $timestamps = false;

    public static function stats($column)
	{
		if( \Auth::check() )
		{
			$now = self::whereDate(date('Y-m-d'))->whereUserId(\Auth::user()->id)->first();

			if($now) {
				self::whereDate(date('Y-m-d'))->whereUserId(\Auth::user()->id)->update(array(
					$column => \DB::raw( $column . '+ 1' ) 
				));
			} else {
				self::create([ 
					'date' => date('Y-m-d'), 
					'user_id' => \Auth::user()->id, 
					$column => 1 
				]);
			}
		}
	}
}
